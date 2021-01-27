<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\Exceptions\CreditCardCharactersException;
use LVR\CreditCard\Exceptions\CreditCardChecksumException;
use LVR\CreditCard\Exceptions\CreditCardException;
use LVR\CreditCard\Exceptions\CreditCardLengthException;
use LVR\CreditCard\Exceptions\CreditCardPatternException;
use LVR\CreditCard\Tests\TestCase;

abstract class BaseCardTests extends TestCase
{
    /**
     * @var \LVR\CreditCard\Contracts\CreditCard
     */
    public $instance;

    protected $available_cards = [
        // Firs debit cards
        DankortTest::class,
        ForbrugsforeningenTest::class,
        MaestroTest::class,
        VisaElectronTest::class,
        // Debit cards
        AmericanExpressTest::class,
        DinersClubTest::class,
        DiscoveryTest::class,
        JcbTest::class,
        HipercardTest::class,
        MastercardTest::class,
        UnionPayTest::class,
        VisaTest::class,
        MirTest::class,
    ];

    /** @test **/
    public function it_implemented_correctly()
    {
        $this->assertInstanceOf($this->instance, new $this->instance);
    }

    /** @test **/
    public function it_checks_if_card_number_is_set()
    {
        $this->expectException(CreditCardException::class);
        (new $this->instance)->isValidCardNumber();
    }

    /** @test **/
    public function it_checks_card_number()
    {
        $this->expectException(CreditCardException::class);
        (new $this->instance)
            ->setCardNumber(Str::random(16))
            ->isValidCardNumber();
    }

    /** @test **/
    public function it_can_be_called_directly()
    {
        $this->assertTrue(
            (new $this->instance)
                ->setCardNumber($this->validNumbers()->first())
                ->isValidCardNumber()
        );
    }

    /** @test **/
    public function it_recognises_valid_card_numbers()
    {
        $this->validNumbers()->each(function ($number) {
            $this->assertTrue(
                Validator::make(
                    ['card_number' => $number],
                    ['card_number' => new CardNumber]
                )->passes(),
                sprintf('The number: "%s" is recognized as invalid but should be valid', $number)
            );
        });
    }

    /** @test **/
    public function it_recognises_invalid_card_numbers()
    {
        $this->withoutMiddleware(TrimStrings::class);
        $this->withoutMiddleware(ConvertEmptyStringsToNull::class);

        collect([
            Str::random(16),
        ])->each(function ($number) {
            $this->assertTrue(
                Validator::make(
                    ['card_number' => $number],
                    ['card_number' => [new CardNumber]]
                )->fails(),
                sprintf('The number: "%s" is recognized as valid but should be invalid', $number)
            );
        });
    }

    /** @test **/
    public function it_checks_number_length()
    {
        $this->numbersWithInvalidLength()->each(function ($number) {
            $validator = Validator::make(
                ['card_number' => $number],
                ['card_number' => new CardNumber]
            );

            $this->assertFalse($validator->passes());
            $this->assertTrue($validator->fails());
            $this->assertEquals(
                CardNumber::MSG_CARD_LENGTH_INVALID,
                $validator->messages()->first(),
                sprintf('The number: "%s" is not recognized as invalid length', $number)
            );
        });
    }

    /** @test **/
    public function it_checks_number_checksum()
    {
        $this->numbersWithInvalidCheckSum()->each(function ($number) {
            $validator = Validator::make(
                ['card_number' => $number],
                ['card_number' => new CardNumber]
            );

            $this->assertFalse(
                $validator->passes(),
                sprintf('Number "%s" checksum is correct', $number)
            );

            $this->assertTrue($validator->fails());

            $this->assertEquals(
                CardNumber::MSG_CARD_CHECKSUM_INVALID,
                $validator->messages()->first()
            );
        });
    }

    /** @test **/
    public function it_should_not_match_other_cards()
    {
        collect($this->available_cards)->each(function ($card) {
            if (class_basename($this->instance) != str_replace('Test', '', class_basename($card))) {
                (new $card)->validNumbers()->each(function ($number) use ($card) {
                    $card_instance = (new $card)->instance;
                    if ((new $card_instance)->type() === (new $this->instance)->type()) {
                        try {
                            (new $this->instance)->setCardNumber($number);

                            $this->assertTrue(
                                false,
                                sprintf('%s cards ("%s") pattern matches %s card.', $card, $number, $this->instance)
                            );
                        } catch (CreditCardPatternException $ex) {
                            $this->assertTrue(
                                $ex->getMessage() === sprintf('Wrong "%s" card pattern', $number)
                            );
                        } catch (CreditCardLengthException $ex) {
                            $this->assertTrue(
                                $ex->getMessage() === sprintf('Incorrect "%s" card length', $number)
                            );
                        } catch (CreditCardChecksumException $ex) {
                            $this->assertTrue(
                                $ex->getMessage() === sprintf('Invalid card number: "%s". Checksum is wrong', $number)
                            );
                        } catch (CreditCardCharactersException $ex) {
                            $this->assertTrue(
                                $ex->getMessage() === sprintf('Card number "%s" contains invalid characters', $number)
                            );
                        } catch (CreditCardException $ex) {
                            $this->assertTrue(
                                $ex->getMessage() === 'Card number is not set'
                            );
                        }
                    }
                });
            }
        });
    }

    abstract public function validNumbers(): Collection;

    abstract public function numbersWithInvalidLength(): Collection;

    abstract public function numbersWithInvalidCheckSum(): Collection;
}

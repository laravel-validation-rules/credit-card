<?php

namespace LVR\CreditCard\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\Cards\Card;
use LVR\CreditCard\Exceptions\CreditCardCharactersException;
use LVR\CreditCard\Exceptions\CreditCardException;
use LVR\CreditCard\Factory;
use LVR\CreditCard\Tests\TestCase;

class CardTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider badStrings
     */
    public function it_expects_card_number($input)
    {
        $this->expectException(CreditCardException::class);

        Factory::makeFromNumber($input);
    }

    public static function badStrings()
    {
        return ['empty string' => [''], 'null' => [null]];
    }

    /** @test **/
    public function it_allows_spaces_in_card_numbers()
    {
        $this->assertInstanceOf(Card::class, Factory::makeFromNumber('4111 1111 1111 1111'));
    }

    /** @test **/
    public function it_checks_if_all_card_number_characters_are_numeric()
    {
        $this->expectException(CreditCardCharactersException::class);

        Factory::makeFromNumber('4111111x111111sss111');
    }

    /** @test **/
    public function it_returns_card_name()
    {
        $card = Factory::makeFromNumber('4111 1111 1111 1111');

        $this->assertEquals('visa', $card->name());
    }

    /** @test **/
    public function it_returns_card_brand()
    {
        $card = Factory::makeFromNumber('4111 1111 1111 1111');

        $this->assertEquals('Visa', $card->brand());
    }

    public function test_it_rejects_non_string_card_numbers_without_a_type_error()
    {
        foreach ([['4111111111111111'], null, 4111.5, true] as $input) {
            $this->assertTrue(
                Validator::make(['card_number' => $input], ['card_number' => [new CardNumber]])->fails()
            );
        }

        $this->expectException(CreditCardException::class);

        Factory::makeFromNumber(['4111111111111111']);
    }

    public function test_it_rejects_card_numbers_with_a_decimal_point_or_exponent()
    {
        foreach (['4.11111111111111', '4e11111111111111', '4111111111111.11'] as $input) {
            $this->assertTrue(
                Validator::make(['card_number' => $input], ['card_number' => [new CardNumber]])->fails()
            );

            try {
                Factory::makeFromNumber($input);
                $this->fail(sprintf('"%s" should be rejected', $input));
            } catch (CreditCardCharactersException $ex) {
                $this->assertSame(sprintf('Card number "%s" contains invalid characters', $input), $ex->getMessage());
            }
        }
    }
}

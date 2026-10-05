<?php

namespace LVR\CreditCard\Tests\Unit;

use Illuminate\Support\Facades\Validator;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\Cards\Card;
use LVR\CreditCard\Tests\TestCase;
use LVR\CreditCard\Tests\Unit\Cards\AmericanExpressTest;
use LVR\CreditCard\Tests\Unit\Cards\VisaTest;

class CardCvcTest extends TestCase
{
    /** @test **/
    public function it_check_cvc_by_credit_card()
    {
        $this->assertTrue($this->validator('243')->fails());
        $this->assertTrue($this->validator('1234')->passes());

        $this->assertTrue($this->validator('1234', new AmericanExpressTest)->passes());
        $this->assertFalse($this->validator('243', new AmericanExpressTest)->passes()); // American Express supports only 4 digits

        $this->assertTrue($this->validator('243', new VisaTest)->passes());
        $this->assertTrue($this->validator('1234', new VisaTest)->fails()); // Visa supports only 3 digits

        // Fails with non-digit characters
        $this->assertTrue($this->validator('1e3', new VisaTest)->fails());
        $this->assertTrue($this->validator('-12', new VisaTest)->fails());
        $this->assertTrue($this->validator(['123'], new VisaTest)->fails());
        $this->assertTrue($this->validator("123\n", new AmericanExpressTest)->fails());
        $this->assertTrue($this->validator('1e30', new AmericanExpressTest)->fails());
        $this->assertTrue($this->validator(12, new VisaTest)->fails());

        // Fails with bad card number
        $this->assertTrue(
            Validator::make(
                ['cvc' => '123'],
                ['cvc' => ['required', new CardCvc('123-4123')]]
            )->fails()
        );
    }

    /** @test  */
    public function it_checks_cvc_code_length()
    {
        // Valid
        $this->assertTrue(Card::isValidCvcLength('243'));
        $this->assertTrue(Card::isValidCvcLength('5678'));
        $this->assertTrue(Card::isValidCvcLength(321));
        $this->assertTrue(Card::isValidCvcLength(1234));
        $this->assertTrue(Card::isValidCvcLength('012'));

        // Empty
        $this->assertFalse(Card::isValidCvcLength(''));

        // Non digits
        $this->assertFalse(Card::isValidCvcLength('12e'));
        $this->assertFalse(Card::isValidCvcLength('1e3'));
        $this->assertFalse(Card::isValidCvcLength('1.2'));
        $this->assertFalse(Card::isValidCvcLength('-12'));
        $this->assertFalse(Card::isValidCvcLength('+12'));
        $this->assertFalse(Card::isValidCvcLength(' 12'));
        $this->assertFalse(Card::isValidCvcLength('12 '));
        $this->assertFalse(Card::isValidCvcLength('0x1'));
        $this->assertFalse(Card::isValidCvcLength("123\n"));
        $this->assertFalse(Card::isValidCvcLength('1e30'));
        $this->assertFalse(Card::isValidCvcLength(-12));
        $this->assertFalse(Card::isValidCvcLength(1.5));
        $this->assertFalse(Card::isValidCvcLength(null));
        $this->assertFalse(Card::isValidCvcLength(['123']));

        // Less than 3 digits
        $this->assertFalse(Card::isValidCvcLength('12'));
        $this->assertFalse(Card::isValidCvcLength('1'));
        $this->assertFalse(Card::isValidCvcLength(0));
        $this->assertFalse(Card::isValidCvcLength(1));
        $this->assertFalse(Card::isValidCvcLength(12));

        // More than 4 digits
        $this->assertFalse(Card::isValidCvcLength(12345));
        $this->assertFalse(Card::isValidCvcLength(123456));
        $this->assertFalse(Card::isValidCvcLength('12345'));
        $this->assertFalse(Card::isValidCvcLength('123455'));
    }

    /**
     * @param  string|int  $cvc
     * @param  null  $testCard
     * @return mixed
     */
    protected function validator($cvc, $testCard = null)
    {
        if (! $testCard) {
            $testCard = new AmericanExpressTest();
        }

        return Validator::make(
            [
                'cvc' => $cvc,
            ],
            ['cvc' => ['required', new CardCvc($testCard->validNumbers()->shuffle()->first())]]
        );
    }
}

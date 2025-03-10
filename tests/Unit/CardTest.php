<?php

namespace LVR\CreditCard\Tests\Unit;

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
}

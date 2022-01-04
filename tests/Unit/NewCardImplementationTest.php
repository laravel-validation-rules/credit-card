<?php

namespace LVR\CreditCard\Tests\Unit;

use LVR\CreditCard\Cards\Card;
use LVR\CreditCard\Exceptions\CreditCardChecksumException;
use LVR\CreditCard\Exceptions\CreditCardCvcException;
use LVR\CreditCard\Exceptions\CreditCardLengthException;
use LVR\CreditCard\Exceptions\CreditCardNameException;
use LVR\CreditCard\Exceptions\CreditCardPatternException;
use LVR\CreditCard\Exceptions\CreditCardTypeException;
use LVR\CreditCard\Tests\TestCase;

class NewCardImplementationTest extends TestCase
{
    /** @test **/
    public function new_card_should_have_defined_type_and_should_be_debit_or_credit()
    {
        // Not set
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type;
                protected $name;
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardTypeException $ex) {
            $success = false;
        }
        $this->assertFalse($success);

        // Not debit or credit
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'new';
                protected $name;
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardTypeException $ex) {
            $success = false;
        }
        $this->assertFalse($success);

        // Debit
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'debit';
                protected $name;
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardTypeException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);

        // Credit
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'credit';
                protected $name;
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardTypeException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);
    }

    /** @test **/
    public function new_card_should_have_name_and_should_be_string()
    {
        // Not set
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'credit';
                protected $name;
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardNameException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // Not string
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'credit';
                protected $name = ['name'];
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardNameException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // OK
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardNameException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);
    }

    /** @test **/
    public function new_card_should_have_pattern_and_should_be_string()
    {
        // Not set
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern;
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardPatternException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // Not string
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = ['array'];
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardPatternException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // OK
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardPatternException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);
    }

    /** @test **/
    public function new_card_should_have_number_length_and_should_be_array()
    {
        // Not set
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardLengthException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // Not array
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = 16;
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardLengthException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // OK
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardLengthException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);
    }

    /** @test **/
    public function new_card_should_have_cvc_length_and_should_be_array()
    {
        // Not set
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardCvcException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // Not array
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length = 3;
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardCvcException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // OK
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length = [3, 4];
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardCvcException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);
    }

    /** @test **/
    public function new_card_should_have_check_sum_and_should_be_bool()
    {
        // Not set
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length = [4];
                protected $checksum_test;
            };
            new $newCard;
        } catch (CreditCardChecksumException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // Not bool
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length = [3];
                protected $checksum_test = 'true';
            };
            new $newCard;
        } catch (CreditCardChecksumException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertFalse($success);

        // OK
        $success = true;
        try {
            $newCard = new class extends Card
            {
                public static $pattern = '/^123/';
                protected $type = 'credit';
                protected $name = 'gold';
                protected $number_length = [16];
                protected $cvc_length = [3, 4];
                protected $checksum_test = true;
            };
            new $newCard;
        } catch (CreditCardChecksumException $ex) {
            $success = false;
        } catch (\Exception $ex) {
        }

        $this->assertTrue($success);
    }
}

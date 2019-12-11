<?php

namespace LVR\CreditCard\Cards;

use LVR\CreditCard\Contracts\CreditCard;

class AmericanExpress extends Card implements CreditCard
{
    /**
     * Regular expression for card number recognition.
     *
     * @var string
     */
    public static $pattern = '/^3[47][0-9]/';

    /**
     * Credit card type.
     *
     * @var string
     */
    protected $type = 'credit';

    /**
     * Credit card name.
     *
     * @var string
     */
    protected $name = 'amex';

    /**
     * Brand name.
     *
     * @var string
     */
    protected $brand = 'American Express';

    /**
     * Card number length's.
     *
     * @var array
     */
    protected $number_length = [15, 16];

    /**
     * CVC code length's.
     *
     * @var array
     */
    protected $cvc_length = [3, 4];

    /**
     * Test cvc code checksum against Luhn algorithm.
     *
     * @var bool
     */
    protected $checksum_test = true;
}

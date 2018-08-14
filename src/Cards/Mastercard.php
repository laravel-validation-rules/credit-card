<?php

namespace LVR\CreditCard\Cards;

use LVR\CreditCard\Contracts\CreditCard;

class Mastercard extends Card implements CreditCard
{
    /**
     * Regular expression for card number recognition.
     *
     * @var string
     */
    public static $pattern = '/^(5[0-5]|2(2(2[1-9]|[3-9])|[3-6]|7(0|1|20)))/';

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
    protected $name = 'mastercard';

    /**
     * Brand name.
     *
     * @var string
     */
    protected $brand = 'Mastercard';

    /**
     * Card number length's.
     *
     * @var array
     */
    protected $number_length = [16];

    /**
     * CVC code length's.
     *
     * @var array
     */
    protected $cvc_length = [3];

    /**
     * Test cvc code checksum against Luhn algorithm.
     *
     * @var bool
     */
    protected $checksum_test = true;
}

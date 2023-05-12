<?php

namespace LVR\CreditCard\Cards;

use LVR\CreditCard\Contracts\CreditCard;

class VisaElectron extends Card implements CreditCard
{
    /**
     * Regular expression for card number recognition.
     *
     * @var string
     */
    public static $pattern = '/^4(026|17500|405|508|844|91[37])/';

    /**
     * Credit card type.
     *
     * @var string
     */
    protected $type = 'debit';

    /**
     * Credit card name.
     *
     * @var string
     */
    protected $name = 'visaelectron';

    /**
     * Brand name.
     *
     * @var string
     */
    protected $brand = 'Visa Electron';

    /**
     * Card number length's.
     *
     * @var array
     */
    protected $number_length = [16, 17];

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

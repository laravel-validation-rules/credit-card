<?php

namespace LVR\CreditCard\Cards;

use LVR\CreditCard\Contracts\CreditCard;

class Visa extends Card implements CreditCard
{
    /**
     * Regular expression for card number recognition.
     *
     * @var string
     */
    public static $pattern = '/^4(?!451416|438935|40117[8-9]|45763[1-2]|457393|431274|402934)\d{12}(?:\d{3})/';

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
    protected $name = 'visa';

    /**
     * Brand name.
     *
     * @var string
     */
    protected $brand = 'Visa';

    /**
     * Card number length's.
     *
     * @var array
     */
    protected $number_length = [13, 16];

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

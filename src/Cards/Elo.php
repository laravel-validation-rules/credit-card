<?php

namespace LVR\CreditCard\Cards;

use LVR\CreditCard\Contracts\CreditCard;

class Elo extends Card implements CreditCard
{
    /**
     * Regular expression for card number recognition.
     *
     * @var string
     */
    public static $pattern = '/^((509091)|(636368)|(636297)|(504175)|(438935)|(40117[8-9])|(45763[1-2])|(457393)|(431274)|(50990[0-2])|(5099[7-9][0-9])|(50996[4-9])|(509[1-8][0-9][0-9])|(5090(0[0-2]|0[4-9]|1[2-9]|[24589][0-9]|3[1-9]|6[0-46-9]|7[0-24-9]))|(5067(0[0-24-8]|1[0-24-9]|2[014-9]|3[0-379]|4[0-9]|5[0-3]|6[0-5]|7[0-8]))|(6504(0[5-9]|1[0-9]|2[0-9]|3[0-9]))|(6504(8[5-9]|9[0-9])|6505(0[0-9]|1[0-9]|2[0-9]|3[0-8]))|(6505(4[1-9]|5[0-9]|6[0-9]|7[0-9]|8[0-9]|9[0-8]))|(6507(0[0-9]|1[0-8]))|(65072[0-7])|(6509(0[1-9]|1[0-9]|20))|(6516(5[2-9]|6[0-9]|7[0-9]))|(6550(0[0-9]|1[0-9]))|(6550(2[1-9]|3[0-9]|4[0-9]|5[0-8])))/';

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
    protected $name = 'elo';

    /**
     * Brand name.
     *
     * @var string
     */
    protected $brand = 'Elo';

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

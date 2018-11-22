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
    public static $pattern = '/^(4011(78|79)|43(1274|8935)|45(1416|7393|763(1|2))|50(4175|6699|67[0-7][0-9]|9000)|50(9[0-9][0-9][0-9])|627780|63(6297|6368)|650(03([^4])|04([0-9])|05(0|1)|05([7-9])|06([0-9])|07([0-9])|08([0-9])|4([0-3][0-9]|8[5-9]|9[0-9])|5([0-9][0-9]|3[0-8])|9([0-6][0-9]|7[0-8])|7([0-2][0-9])|541|700|720|727|901)|65165([2-9])|6516([6-7][0-9])|65500([0-9])|6550([0-5][0-9])|655021|65505([6-7])|6516([8-9][0-9])|65170([0-4]))/';

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

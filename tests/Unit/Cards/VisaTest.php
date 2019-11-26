<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\Visa;

class VisaTest extends BaseCardTests
{
    public $instance = Visa::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '4111111111111111',
            '4012888888881881',
            '4222222222222',
            '4462030000000000',
            '4484070000000000',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '4111111',
            '422222222222',
            '42222222222222',
            '401288888888188',
            '44620300000000000',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '4111111111111112',
            '4012888888881882',
            '4222222222221',
        ]);
    }
}

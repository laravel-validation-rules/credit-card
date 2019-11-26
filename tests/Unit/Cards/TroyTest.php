<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\Troy;

class TroyTest extends BaseCardTests
{
    public $instance = Troy::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '9792112633252339',
            '9792020000000001',
            '9792030000000000',
            '9792122738534192',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '9711111',
            '971111111111111',
            '97110009901394241',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '9792112633252341',
            '9792112635452339',
        ]);
    }
}

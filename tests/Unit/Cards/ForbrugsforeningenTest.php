<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\Forbrugsforeningen;

class ForbrugsforeningenTest extends BaseCardTests
{
    public $instance = Forbrugsforeningen::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '6007220000000004',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '6007220',
            '60072200000000041',
            '600722000000000',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '6007220000000003',
            '6007220000000002',
        ]);
    }
}

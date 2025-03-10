<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\Elo;

class EloTest extends BaseCardTests
{
    public $instance = Elo::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '6363685305150464',
            '6363682833437620',
            '4514165077816223',
            '4389354567568609',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '6011111',
            '601111111111111',
            '60110009901394241',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '6011111111111118',
            '6011000990139423',
        ]);
    }
}

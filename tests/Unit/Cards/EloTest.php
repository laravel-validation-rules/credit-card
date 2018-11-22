<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use LVR\CreditCard\Cards\Elo;
use Illuminate\Support\Collection;

class EloTest extends BaseCardTests
{
    public $instance = Elo::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '6362970000457013',
            '6363684432099819',
            '6363688464312800',
            '4576359945699789',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '636297',
            '636297000045701363',
            '45763599456997',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '4576359945699781',
            '6362970000457014',
        ]);
    }
}

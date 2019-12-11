<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\VisaElectron;

class VisaElectronTest extends BaseCardTests
{
    public $instance = VisaElectron::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '4917300800000000',
            '4479651508787615',
            '4113550663468031',
            '49174917491749174',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '49173008000',
            '447965150878761',
            '41135506634680311',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '4917300800000002',
            '4479651508787616',
            '4113550663468032',
        ]);
    }
}

<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\Maestro;

class MaestroTest extends BaseCardTests
{
    public $instance = Maestro::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '5052336403648441',
            '5604136732063111',
            '5744566068012822',
            '5812314553576036',
            '6185514471836621',
            '6759000000000018',
            '6759649826438453',
            '6874748785422365',
            '6903054836430043',
            '6900078482187022',
            '586824160825533338',
            '6799990100000000019',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '690305483',
            '67999901000000000191',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '6759649826438454',
            '6799990100000000012',
        ]);
    }
}

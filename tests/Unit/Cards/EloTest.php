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
            '4389355418071677',
            '6363688911766020',
            '6363688294262910',
            '6363681720014757',
            '6363681884883385',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '636368188488338',
            '6363681720014757',
            '636368172001475789',
            '636368172001',
            '43893554180716770000',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '4389355400000000',
            '6363688911111111',
            '6363681111000000',
        ]);
    }
}

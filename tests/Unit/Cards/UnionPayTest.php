<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\UnionPay;

class UnionPayTest extends BaseCardTests
{
    public $instance = UnionPay::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '6236164557615827',
            '6287540550853465',
            '6223824031662118',
            '6270146778108770',
            '6271136264806203568',
            '6236265930072952775',
            '6204679475679144515',
            '6216657720782466507',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '6223824',
            '627014677810877',
            '62711362648062035681',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '6823824021882117',
        ]);
    }
}

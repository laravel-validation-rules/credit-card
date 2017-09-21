<?php

namespace LVR\CreditCard\Tests\Unit\Cards;

use Illuminate\Support\Collection;
use LVR\CreditCard\Cards\Mastercard;

class MastercardTest extends BaseCardTests
{
    public $instance = Mastercard::class;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function validNumbers(): Collection
    {
        return collect([
            '5121647321685225',
            '5122174301617622',
            '5127175625251274',
            '5137481033376283',
            '5177437335456778',
            '5218416266166136',
            '5221225025781753',
            '5288773846741167',
            '5289000128841542',
            '5314501768582022',
            '5315767547680408',
            '5323510844618006',
            '5324205751381263',
            '5369907624452512',
            '5405108775647721',
            '5454545454545454',
            '5520710871255620',
            '5522002281762173',
            '5555555555554444',
            '5592090153823426',
            '2221000002222221',
            '2222000000000008',
            '2223000000000007',
            '2224000000000006',
            '2225000000000005',
            '2226000000000004',
            '2227000000000003',
            '2228000000000002',
            '2229000000000001',
            '2230000000000008',
            '2240000000000006',
            '2250000000000003',
            '2260000000000001',
            '2270000000000009',
            '2280000000000007',
            '2290000000000005',
            '2300000000000003',
            '2400000000000002',
            '2500000000000001',
            '2600000000000000',
            '2700000000000009',
            '2710000000000007',
            '2720999999999996',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidLength(): Collection
    {
        return collect([
            '512164',
            '512164732168522',
            '51271756252512751',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function numbersWithInvalidCheckSum(): Collection
    {
        return collect([
            '5121647321685222',
            '5122174301617623',
            '5127175625251275',
            '5137481033376284',
        ]);
    }
}

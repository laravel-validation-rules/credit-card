<?php

namespace LVR\CreditCard\Tests\Unit;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use LVR\CreditCard\CardExpirationDate;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\ExpirationDateValidator;
use LVR\CreditCard\Tests\TestCase;

class CardExpirationTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    /** @test  */
    public function it_checks_expiration_year()
    {
        // Invalid year
        $this->assertFalse($this->yearValidator(' ')->passes());
        $this->assertFalse($this->yearValidator(1)->passes());
        $this->assertFalse($this->yearValidator(1900)->passes());
        $this->assertFalse($this->yearValidator(2010)->passes());

        // Integer values
        $this->assertTrue($this->yearValidator(intval(date('Y')))->passes());

        // Not numbers
        $this->assertFalse($this->yearValidator('j2020')->passes());
        $this->assertFalse($this->yearValidator('asdasd')->passes());

        // Past year
        $this->assertFalse($this->yearValidator(date('Y', strtotime('-1 year')))->passes());

        // Next year
        $this->assertTrue($this->yearValidator(date('Y', strtotime('+1 year')))->passes());
    }

    /** @test */
    public function it_checks_expiration_month()
    {
        // Invalid month
        $this->assertFalse($this->monthValidator('')->passes());
        $this->assertFalse($this->monthValidator(13)->passes());
        $this->assertFalse($this->monthValidator(0)->passes());
        $this->assertFalse($this->monthValidator(20)->passes());

        // Integer values
        $this->assertTrue($this->monthValidator(intval(date('m')))->passes());

        // Not numbers
        $this->assertFalse($this->monthValidator('d5')->passes());
        $this->assertFalse($this->monthValidator('a')->passes());
        $this->assertFalse($this->monthValidator('12s')->passes());

        // Future month
        $this->assertTrue($this->monthValidator(Carbon::now()->addMonth()->month)->passes());

        // Past year, current month
        $this->assertFalse(
            $this->monthValidator(Carbon::now()->month, Carbon::now()->subYear()->year)->passes()
        );

        // Current year, current month
        $this->assertTrue($this->monthValidator(date('m'))->passes());
    }

    /** @test */
    public function it_checks_expiration_date()
    {
        $this->assertFalse($this->dateValidator('-11', 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('Y'), 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('Y').'-', 'Y-m')->passes());
        $this->assertFalse($this->dateValidator('-', 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('Y-m'), 'Ym')->passes());
        $this->assertFalse($this->dateValidator(date('Y-m-d H:i:s'), 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('Ymd'), 'Ym')->passes());

        $this->assertTrue($this->dateValidator(date('Y-m'), 'Y-m')->passes());
        $this->assertTrue($this->dateValidator(date('mY'), 'mY')->passes());
        $this->assertTrue($this->dateValidator(date('Ym'), 'Ym')->passes());
        $this->assertTrue($this->dateValidator(date('YM'), 'YM')->passes());
        $this->assertTrue($this->dateValidator(date('ym'), 'ym')->passes());

        // Invalid month
        $this->assertFalse($this->dateValidator(date('Y-0'), 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('Y0'), 'Ym')->passes());
        $this->assertFalse($this->dateValidator(date('Y-99'), 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('Y-14'), 'Y-m')->passes());

        // Invalid year
        $this->assertFalse($this->dateValidator(date('1-n'), 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('10-m'), 'Ym')->passes());
        $this->assertFalse($this->dateValidator(date('100-m'), 'Y-m')->passes());
        $this->assertFalse($this->dateValidator(date('1900m'), 'Ym')->passes());

        // Integer values
        $this->assertTrue($this->dateValidator(intval(date('Y').date('m')), 'Ym')->passes());

        // Not numbers
        $this->assertFalse($this->dateValidator('j2020-d5', 'Y-m')->passes());
        $this->assertFalse($this->dateValidator('Ym', 'Ym')->passes());
        $this->assertFalse($this->dateValidator('2020/asd', 'Y/m')->passes());

        // Past year, future month
        $timestamp = strtotime('+1 month');
        $d = (date('Y', $timestamp) - 1).'-'.date('m', $timestamp);
        $this->assertFalse($this->dateValidator($d, 'Y-m')->passes());

        // Current year, past month
        $timestamp = strtotime('-1 month');
        $d = date('Y', $timestamp).'-'.date('m', $timestamp);
        $this->assertFalse($this->dateValidator($d, 'Y-m')->passes());

        // Next year
        $timestamp = strtotime('+1 year');
        $d = date('Y', $timestamp).'-'.date('m', $timestamp);
        $this->assertTrue($this->dateValidator($d, 'Y-m')->passes());

        // Month Overflow
        $timestamp = strtotime('-1 year');
        $overflow = date('m', $timestamp) + 12;
        $d = date('Y', $timestamp).'-'.$overflow;
        $this->assertFalse($this->dateValidator($d, 'Y-m')->passes());
    }

    public function test_it_accepts_valid_dates_in_formats_carbon_parse_cannot_read()
    {
        // Carbon::parse() used to be called before createFromFormat() and threw
        // for these values, so they were rejected whatever format was given.
        Carbon::setTestNow('2026-10-08 12:00:00');

        $this->assertTrue($this->dateValidator('12/2030', 'm/Y')->passes());
        $this->assertTrue($this->dateValidator('01/2027', 'm/Y')->passes());
        $this->assertTrue($this->dateValidator('12-30', 'm-y')->passes());
        $this->assertTrue($this->dateValidator('05/40', 'm/y')->passes());

        // Still rejected: wrong format, invalid month, past date
        $this->assertFalse($this->dateValidator('12/30', 'm/Y')->passes());
        $this->assertFalse($this->dateValidator('13/2030', 'm/Y')->passes());
        $this->assertFalse($this->dateValidator('12/2030 ', 'm/Y')->passes());
        $this->assertFalse($this->dateValidator('09/2026', 'm/Y')->passes());
    }

    /** @test */
    public function it_does_not_overflow_short_months_at_the_end_of_month()
    {
        // Parsing without a day used to take today's day, so on the 29th-31st
        // a shorter month rolled over into the next one (e.g. Feb 31 -> Mar 3).
        // 2026 is not a leap year: Jan 28 is the last day without rollover
        // (Feb 28 exists), Jan 29 is the first day with it (Feb 29 -> Mar 1).
        Carbon::setTestNow('2026-01-28 12:00:00');

        $this->assertTrue($this->dateValidator('02/26', 'm/y')->passes());
        $this->assertTrue($this->dateValidator('2026-02', 'Y-m')->passes());

        Carbon::setTestNow('2026-01-29 12:00:00');

        $this->assertTrue($this->dateValidator('02/26', 'm/y')->passes());
        $this->assertTrue($this->dateValidator('2026-02', 'Y-m')->passes());

        Carbon::setTestNow('2026-01-31 12:00:00');

        $this->assertTrue($this->dateValidator('02/26', 'm/y')->passes());
        $this->assertTrue($this->dateValidator('2026-02', 'Y-m')->passes());
        $this->assertTrue($this->dateValidator('2026-01', 'Y-m')->passes());
        $this->assertFalse($this->dateValidator('2025-12', 'Y-m')->passes());
        $this->assertTrue(ExpirationDateValidator::validate('2026', '02'));
        $this->assertTrue(ExpirationDateValidator::validate('2026', '01'));
        $this->assertFalse(ExpirationDateValidator::validate('2025', '12'));

        Carbon::setTestNow('2026-03-31 12:00:00');

        $this->assertTrue($this->dateValidator('04/26', 'm/y')->passes());
        $this->assertTrue($this->dateValidator('2026-04', 'Y-m')->passes());
        $this->assertFalse($this->dateValidator('2026-02', 'Y-m')->passes());
        $this->assertTrue(ExpirationDateValidator::validate('2026', '04'));
        $this->assertFalse(ExpirationDateValidator::validate('2026', '02'));
    }

    /** @test */
    public function it_is_valid_through_the_last_moment_of_the_expiration_month()
    {
        Carbon::setTestNow('2026-12-31 23:59:59');
        $this->assertTrue(ExpirationDateValidator::validate('2026', '12'));
        $this->assertTrue($this->dateValidator('2026-12', 'Y-m')->passes());

        Carbon::setTestNow('2027-01-01 00:00:00');
        $this->assertFalse(ExpirationDateValidator::validate('2026', '12'));
        $this->assertFalse($this->dateValidator('2026-12', 'Y-m')->passes());
    }

    /** @test **/
    public function it_can_be_called_directly()
    {
        $this->assertFalse(ExpirationDateValidator::validate('', date('m')));
        $this->assertFalse(ExpirationDateValidator::validate(date('y'), ''));
        $this->assertFalse(ExpirationDateValidator::validate(' ', ' '));
        $this->assertFalse(ExpirationDateValidator::validate('2018', '13'));
        $this->assertFalse(ExpirationDateValidator::validate('2018', '99'));
        $this->assertTrue(ExpirationDateValidator::validate(date('Y'), date('m')));
        $this->assertTrue(ExpirationDateValidator::validate(date('y'), date('m')));
    }

    /** @test **/
    public function it_validates_two_digits_year_format()
    {
        $validator = Validator::make(
            ['expiration_year' => date('y')],
            ['expiration_year' => ['required', new CardExpirationYear(date('m'))]]
        );

        $this->assertTrue($validator->passes());
    }

    /**
     * @param  string  $year
     * @return mixed
     */
    protected function yearValidator(string $year)
    {
        return Validator::make(
            [
                'expiration_year' => $year,
            ],
            ['expiration_year' => ['required', new CardExpirationYear(date('m'))]]
        );
    }

    /**
     * @param  string  $month
     * @param  null  $year
     * @return mixed
     */
    protected function monthValidator(string $month, $year = null)
    {
        $year = $year ?? Carbon::now()->addYear()->year;

        return Validator::make(
            [
                'expiration_month' => $month,
            ],
            [
                'expiration_month' => [
                    'required',
                    new CardExpirationMonth($year),
                ],
            ]
        );
    }

    /**
     * @param  string  $date
     * @param  string  $format
     * @return mixed
     */
    protected function dateValidator(string $date, string $format)
    {
        return Validator::make(
            [
                'expiration_date' => $date,
            ],
            ['expiration_date' => ['required', new CardExpirationDate($format)]]
        );
    }
}

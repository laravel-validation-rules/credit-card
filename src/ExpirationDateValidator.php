<?php

namespace LVR\CreditCard;

use Carbon\Carbon;
use LVR\CreditCard\Exceptions\CreditCardExpirationDateException;

class ExpirationDateValidator
{
    /**
     * @var string
     */
    protected $year;

    /**
     * @var string
     */
    protected $month;

    /**
     * ExpirationDateValidator constructor.
     *
     * @param string $year
     * @param string $month
     *
     * @throws \LVR\CreditCard\Exceptions\CreditCardExpirationDateException
     */
    public function __construct(string $year, string $month)
    {
        if ($year == '' || $month == '') {
            throw new CreditCardExpirationDateException;
        }

        $this->year = $year;
        $this->month = str_pad($month, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param string $year
     * @param string $month
     *
     * @return mixed
     */
    public static function validate(string $year, string $month)
    {
        return (new static($year, $month))->isValid();
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValidYear()
            && $this->isValidMonth()
            && $this->isFeatureDate();
    }

    /**
     * @return bool
     */
    protected function isValidYear()
    {
        return (bool) preg_match('/^20\d\d$/', $this->year);
    }

    /**
     * @return bool
     */
    protected function isValidMonth()
    {
        return (bool) preg_match('/^(0[1-9]|1[0-2])$/', $this->month);
    }

    /**
     * @return bool
     */
    protected function isFeatureDate()
    {
        return Carbon::now()->startOfDay()->lte(
            Carbon::createFromFormat('Y-m', $this->year.'-'.$this->month)->endOfDay()
        );
    }
}

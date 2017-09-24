<?php

namespace LVR\CreditCard;

use Illuminate\Contracts\Validation\Rule;

class CardExpirationMonth implements Rule
{
    const MSG_CARD_EXPIRATION_MONT_INVALID = 'validation.credit_card.card_expiation_month_invalid';

    /**
     * Year field name.
     *
     * @var string
     */
    protected $year;

    /**
     * CardExpirationMonth constructor.
     *
     * @param string $year
     */
    public function __construct(string $year)
    {
        $this->year = $year;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return (new ExpirationDateValidator($this->year, $value))
                ->isValid();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return static::MSG_CARD_EXPIRATION_MONT_INVALID;
    }
}

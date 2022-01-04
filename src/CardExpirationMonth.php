<?php

namespace LVR\CreditCard;

use Illuminate\Contracts\Validation\Rule;

class CardExpirationMonth implements Rule
{
    const MSG_CARD_EXPIRATION_MONTH_INVALID = 'validation.credit_card.card_expiration_month_invalid';

    /**
     * Year field name.
     *
     * @var string
     */
    protected $year;

    /**
     * CardExpirationMonth constructor.
     *
     * @param  string  $year
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new ExpirationDateValidator($this->year, $value))
            ->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans(static::MSG_CARD_EXPIRATION_MONTH_INVALID);
    }
}

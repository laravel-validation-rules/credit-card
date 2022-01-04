<?php

namespace LVR\CreditCard;

use Illuminate\Contracts\Validation\Rule;

class CardCvc implements Rule
{
    const MSG_CARD_CVC_INVALID = 'validation.credit_card.card_cvc_invalid';

    protected $message;

    /**
     * Credit card number.
     *
     * @var string
     */
    protected $card_number;

    public function __construct($card_number)
    {
        $this->message = static::MSG_CARD_CVC_INVALID;
        $this->card_number = $card_number;
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
        try {
            return Factory::makeFromNumber($this->card_number)->isValidCvc($value);
        } catch (\Exception $ex) {
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
        return trans($this->message);
    }
}

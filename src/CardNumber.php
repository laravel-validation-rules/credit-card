<?php

namespace LVR\CreditCard;

use Illuminate\Contracts\Validation\Rule;
use LVR\CreditCard\Exceptions\CreditCardException;
use LVR\CreditCard\Exceptions\CreditCardLengthException;
use LVR\CreditCard\Exceptions\CreditCardChecksumException;

class CardNumber implements Rule
{
    const MSG_CARD_INVALID = 'validation.credit_card.card_invalid';
    const MSG_CARD_PATTER_INVALID = 'validation.credit_card.card_pattern_invalid';
    const MSG_CARD_LENGTH_INVALID = 'validation.credit_card.card_length_invalid';
    const MSG_CARD_CHECKSUM_INVALID = 'validation.credit_card.card_checksum_invalid';

    protected $message = '';

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
        $value = preg_replace('/[^0-9]/', '', $value);    
        try {
            return Factory::makeFromNumber($value)->isValidCardNumber();
        } catch (CreditCardLengthException $ex) {
            $this->message = self::MSG_CARD_LENGTH_INVALID;

            return false;
        } catch (CreditCardChecksumException $ex) {
            $this->message = self::MSG_CARD_CHECKSUM_INVALID;

            return false;
        } catch (CreditCardException $ex) {
            $this->message = self::MSG_CARD_INVALID;

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

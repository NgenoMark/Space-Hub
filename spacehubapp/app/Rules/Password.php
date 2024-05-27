<?php 

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/[A-Z]/', $value) && // Uppercase letter
               preg_match('/[a-z]/', $value) && // Lowercase letter
               preg_match('/[0-9]/', $value) && // Digit
               preg_match('/[@$!%*#?&]/', $value) && // Special character
               strlen($value) >= 8; // Minimum length
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    }
}

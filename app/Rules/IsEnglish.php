<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsEnglish implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return is_english($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'প্রতিষ্ঠানের নাম  এবং রাউটিং নং ইংরেজিতে দিন';
    }
}

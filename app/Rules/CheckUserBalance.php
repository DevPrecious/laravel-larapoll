<?php

namespace App\Rules;

use App\Models\wallet;
use Illuminate\Contracts\Validation\Rule;

class CheckUserBalance implements Rule
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
        $user_wallet = wallet::where('user_id', auth()->id())->first();
        if ($user_wallet <= $value) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Insufficient Balance';
    }
}

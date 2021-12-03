<?php

namespace App\Rules;

use App\Models\Poll;
use Illuminate\Contracts\Validation\Rule;

class CheckStake implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $theid;

    public function __construct($param)
    {
        $this->theid = $param;
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
        $get_stake = Poll::where('id', $this->theid)->first();
        $int = (int)$value;
        $price = (int)$get_stake->stake;
        // dd($int);
        if ($price < $int) {
            return true;
        } else {
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
        return 'Your stake must be equal or higher than the inital stake';
    }
}

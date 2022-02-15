<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckSetPriceSizeRule implements Rule
{

    protected array $messages;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->messages[] = 'The request array';
        $this->messages[] = 'must have';
        $this->messages[] = 'no more';
        $this->messages[] = 'than 1000 items';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // ToDo 1000 - in config with getenv
        // ToDo maybe slice array to 1000 items force
        if (sizeof($value) <= 1000) {
            return true;
        }
    }


    public function message()
    {
        $error = [
            //'The request array must have no more than 1000 items'
            $this->getErrorsMessage(),
        ];

        return response()->json($error, 422);
    }

    public function getErrorsMessage(): string
    {
        return implode(' ', $this->messages);
    }
}

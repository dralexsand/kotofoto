<?php

namespace App\Rules;

use App\Services\PriceService;
use Illuminate\Contracts\Validation\Rule;

class CheckSetPriceArrayRule implements Rule
{
    protected array $messages;
    protected PriceService $service;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new PriceService();
        $this->messages[] = 'Ошибка в структуре массивов';
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
        $messages = $this->service->validateRequestArray($value);
        if (empty($messages)) {
            return true;
        }
        $this->messages = $messages;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->getErrorsMessage();
    }

    // ToDo cumulative message
    public function getErrorsMessage(): string
    {
        return implode('\n', $this->messages);
    }
}

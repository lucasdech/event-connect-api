<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EventValidator.
 *
 * @package namespace App\Validators;
 */
class EventValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => ['required','string'],
            'is_private' => ['required','boolean'],
            'password' => ['nullable','string'],
            'description' => ['required','string'],
            'starting_at' => ['required','date'],
            'location' => ['required','string'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => ['sometimes','string'],
            'is_private' => ['sometimes','boolean'],
            'password' => ['nullable','string'],
            'description' => ['sometimes','string'],
            'starting_at' => ['sometimes','date'],
            'location' => ['sometimes','string'],
        ],
    ];
}

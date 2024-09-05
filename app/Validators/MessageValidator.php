<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class MessageValidator.
 *
 * @package namespace App\Validators;
 */
class MessageValidator extends LaravelValidator
{
    
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'content' => ['required','string'],
            'event_id' => ['required','int'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'content' => ['sometimes','string'],
        ],
    ];
}

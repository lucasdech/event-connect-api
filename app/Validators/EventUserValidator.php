<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EventUserValidator.
 *
 * @package namespace App\Validators;
 */
class EventUserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
             'event_id' => ['required','int'],
             'user_id' => ['required','int'],
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}

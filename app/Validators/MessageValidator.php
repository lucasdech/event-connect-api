<?php

namespace App\Validators;

use App\Rules\ChatRule;
use App\Rules\ForbiddenWordRule;
use Illuminate\Contracts\Validation\Factory;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class MessageValidator.
 *
 * @package namespace App\Validators;
 */
class MessageValidator extends LaravelValidator
{
    
    public function __construct(Factory $validator, ForbiddenWordRule $forbiddenWordRule)
    {
        parent::__construct($validator);
        /**
         * Validation Rules
         *
         * @var array
         */
        $this->rules = [
            ValidatorInterface::RULE_CREATE => [
                'content' => [ 'required','string', $forbiddenWordRule],
                'event_id' => ['required','int'],
            ],
            ValidatorInterface::RULE_UPDATE => [
                'content' => ['sometimes','string'],
            ],
        ];
    }

    protected $messages = [
        'required' => "The :attribute field is required",
        'string' => "The :attribute must be string",
        'int' => "The :attribute must be int",
    ];
    
}

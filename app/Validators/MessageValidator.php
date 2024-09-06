<?php

namespace App\Validators;

use App\Rules\ChatRule;
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
    
    protected $chatRule;
    public function __construct(Factory $validator, ChatRule $chatRule)
    {
        parent::__construct($validator);
        $this->chatRule = $chatRule;
        /**
         * Validation Rules
         *
         * @var array
         */
        $this->rules = [
            ValidatorInterface::RULE_CREATE => [
                'content' => [ 'required','string', $chatRule],
                'event_id' => ['required','int'],
            ],
            ValidatorInterface::RULE_UPDATE => [
                'content' => ['sometimes','string'],
            ],
        ];
    }
    
}

<?php

namespace App\Validators;

use App\Rules\NsfwRule;
use Illuminate\Contracts\Validation\Factory;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{

    protected $nsfwRule;
    public function __construct(Factory $validator, NsfwRule $nsfwRule)
    {
        parent::__construct($validator);
        $this->nsfwRule = $nsfwRule;
        dd($nsfwRule);

    }
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            // 'profile_picture' => [$this->nsfwRule],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => 'max:8',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}

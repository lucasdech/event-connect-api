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
    }
    
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            // 'profile_picture' => [$this->nsfwRule],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => 'min:8',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => ['sometimes','string','max:255'],
            'profile_picture' => ['sometimes','image','max:2048'],
            'email' => ['sometimes','string','email','max:255','unique:users'],
            'password' => ['sometimes','string','min:8'],
        ],
    ];
}

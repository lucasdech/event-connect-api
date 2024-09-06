<?php

namespace App\Rules;

use App\Models\ForbiddenWord;
use App\Repositories\ForbiddenWordRepository;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;


class ChatRule implements Rule
{

    protected $bannedWords;

    public function __construct(private ForbiddenWordRepository $forbiddenWordRepository)
    {
        
    }
    public function passes($attribute, $value)
    {
        foreach ($$this->forbiddenWordRepository->pluck("word") as $forbiddenWord) {
            if(str_contains($value, $forbiddenWord)){
                $this->bannedWords[] = $forbiddenWord;
            }
            
        }

        return count($this->bannedWords) === 0;
    }

    public function message()
    {
        return 'Le message contient des mots interdits' . implode(', ', array_unique($this->bannedWords));
    }


    public function __toString()
    {
        return 'ChatRule';
    }
}

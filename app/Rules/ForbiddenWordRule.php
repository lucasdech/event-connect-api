<?php

namespace App\Rules;

use App\Repositories\ForbiddenWordRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ForbiddenWordRule implements ValidationRule
{

    protected $bannedWords = [];

    public function __construct(private ForbiddenWordRepository $forbiddenWordRepository) {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->forbiddenWordRepository->pluck("word") as $forbiddenWord) {
            if(str_contains($value, $forbiddenWord)){
                $this->bannedWords[] = $forbiddenWord;
            }
        }

        if(count($this->bannedWords) > 0) {
            $fail("Le contenu contient des mots interdits : ". implode(', ', $this->bannedWords));
        }
    }
}

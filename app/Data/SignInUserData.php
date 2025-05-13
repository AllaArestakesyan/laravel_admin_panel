<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class SignInUserData extends Data
{
    public function __construct(

        #[Required, Email]
        public string $email,

        #[Required, Min(6)]
        public string $password
    ) {}
}

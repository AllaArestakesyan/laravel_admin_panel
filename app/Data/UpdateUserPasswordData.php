<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateUserPasswordData extends Data
{
    public function __construct(

        #[Required(), Min(6)]
        public string $old_password,
        
        #[Required(), Min(6)]
        public string $password,
        
        #[Required(), Min(6)]
        public string $confirm_password
    ) {}
}

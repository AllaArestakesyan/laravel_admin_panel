<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class StoreAdminData extends Data
{
    public function __construct(
        
        #[Required()]
        public string $name,

        #[Required(), Email]
        public string $email,

        #[Required(), Min(6)]
        public string $password,
        
        #[Required(), Min(6)]
        public string $confirm_password,

        #[Required(), In(['admin', 'manager'])]
        public string $role
    ) {}
}

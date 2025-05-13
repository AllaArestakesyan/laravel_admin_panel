<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\In;

class UpdateAdminData extends Data
{
    public function __construct(
        
        #[Required()]
        public string $name,

        #[Required(), In(['admin', 'manager'])]
        public string $role
    ) {}
}

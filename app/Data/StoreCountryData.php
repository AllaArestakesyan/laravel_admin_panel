<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class StoreCountryData extends Data
{
    public function __construct(
        
        #[Required()]
        public string $name,

        #[Required()]
        public string $formatted_address,
       
        #[Required()]
        public string $url,

    ) {}
}

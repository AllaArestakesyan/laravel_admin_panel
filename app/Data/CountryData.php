<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CountryData extends Data
{
    public function __construct(

        #[Required()]
        public int $id,

        #[Required()]
        public string $name,

        #[Required()]
        public string $formatted_address,

        #[Required()]
        public string $url
    ) {
    }
}

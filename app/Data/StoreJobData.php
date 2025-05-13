<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class StoreJobData extends Data
{
    public function __construct(

        #[Required()]
        public string $title,

        #[Required()]
        public string $description,
        
        #[Required()]
        public string $budget,
    
        #[Required]
        public array $skills
    
    ) {}
}

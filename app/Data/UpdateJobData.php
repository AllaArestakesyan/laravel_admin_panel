<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateJobData extends Data
{
    public function __construct(
        
        public string $title,

        public string $description,
        
        public string $budget,
    
        public ?array $skills
    ) {}
}

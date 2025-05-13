<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateSkillData extends Data
{
    public function __construct(
       
        #[Required()]
        public string $name
    ) {}
}

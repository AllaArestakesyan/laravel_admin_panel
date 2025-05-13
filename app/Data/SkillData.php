<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class SkillData extends Data
{
    public function __construct(

        #[Required()]
        public int $id,

        #[Required()]
        public string $name,

        #[ArrayType(JobData::class)]
        public Collection|array|null $jobs = null
    ) {
    }
}

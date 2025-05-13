<?php

namespace App\Data;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class JobData extends Data
{
    public function __construct(

        public int $id,

        public string $title,

        public string $description,

        public string $budget,

        #[ArrayType(SkillData::class)]
        public Collection|array|null $skills = null,

        #[WithCast(DateTimeInterfaceCast::class, ['format' => 'Y-m-d'])]
        public ?DateTime $updated_at

    ) {
    }
}

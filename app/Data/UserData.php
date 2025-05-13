<?php

namespace App\Data;

use DateTime;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class UserData extends Data
{
        public int $id;
        
        #[Required()]
        public string $name;

        #[Required(), Email]
        public string $email;

        #[WithCast(DateTimeInterfaceCast::class, format: "Y-m-d")]
        public DateTime $created_at;

        public ?string $avatar = null;
}

<?php

namespace App\Data;

use DateTime;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class AdminData extends Data
{
    
    #[Required()]
    public int $id;
    
    #[Required()]
    public string $name;

    #[Required(), Email]
    public string $email;

    #[Required()]
    public array $roles;

    #[WithCast(DateTimeInterfaceCast::class, ['format' => 'Y-m-d'])]
    public DateTime $created_at;
}
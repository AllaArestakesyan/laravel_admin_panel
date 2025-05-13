<?php
namespace App\Data;

use Spatie\LaravelData\Data;

class ResponseData extends Data
{
    public function __construct(
        
        public bool $error,

        public string $message
    ) {}
}

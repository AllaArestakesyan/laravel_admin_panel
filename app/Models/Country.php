<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    protected $fillable = [
        'name',
        'formatted_address',
        'url',
        'user_id',
    ]; 

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

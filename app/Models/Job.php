<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'budget',
        'assigned_to',
    ]; 

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }


}

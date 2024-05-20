<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batiment extends Model
{
    use HasFactory, SoftDeletes, Userstamps;
    protected $fillable = [
        'libbat',

    ];

    public function productions(): HasMany
    {
        return $this->hasMany(Production::class);
    }
}

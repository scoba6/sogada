<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Production extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $fillable = [
        'datprd',
        'zone_id',
        'batiment_id',
        'agepou',
        'nbrpou',
        'nbrcrt',
        'prdjrn',
        'nbrcas',
        'nbrdcd',
        'cnsali',
        'nbrsac'
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function batiment(): BelongsTo
    {
        return $this->belongsTo(Batiment::class);
    }



}

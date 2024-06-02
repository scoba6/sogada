<?php

namespace App\Models;


use App\Models\Planpro;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

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

    /**
     * Get the user associated with the Production
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function planpro(): HasoNe
    {
        return $this->hasOne(Planpro::class);

    }

    /**
     * Get the user associated with the Production
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function planconso(): HasOne
    {
        return $this->hasOne(Planconso::class);
    }






}

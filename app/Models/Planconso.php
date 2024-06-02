<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planconso extends Model
{
    use HasFactory, Userstamps, SoftDeletes;
    protected $fillable = [
        'production_id',
        'produit_id',
        'nbrsac'
    ];

    /**
     * Get the production that owns the Planconso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }

    /**
     * Get the produiit associated with the Planconso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function produit(): HasOne
    {
        return $this->hasOne(Produit::class);
    }


}

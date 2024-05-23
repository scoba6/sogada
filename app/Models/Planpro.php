<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planpro extends Model
{
    use HasFactory, Userstamps, SoftDeletes;
    protected $fillable = [
        'production_id',
        'vaccin_id',
        'dosepr'
    ];

    /**
     * Get the user that owns the Planpro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produc(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }
    /**
     * Get the vaccin that owns the Planpro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vaccin(): HasOne
    {
        return $this->hasOne(Vaccin::class, 'vaccin_id', 'id');
    }


}

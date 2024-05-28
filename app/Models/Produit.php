<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory, Userstamps,SoftDeletes;

    protected $fillable = [
        'groupe_id',
        'libpro',
        'codbar',
        'ugspro',
        'imgpro',
        'seupro',
        //'vstock',
        'statut'
    ];

    /**
     * Get the groupe that owns the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupe(): BelongsTo
    {
        return $this->belongsTo(Groupe::class,'groupe_id','id');
    }

    /**
     * Get all of the comments for the Produit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stock(): HasMany
    {
        return $this->hasMany(Prostock::class);
    }
}

<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccin extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    protected $fillable = [
       'libvac'
    ];



}

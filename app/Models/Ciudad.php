<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    public $timestamps = false;
    protected $table = 'ciudades';
    protected $primaryKey = 'id_ciudad';

    protected $fillable = [
        'id_ciudad', 'ciudad'
    ];
}

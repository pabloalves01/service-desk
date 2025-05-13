<?php

namespace App\Models\eventos;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    protected $table = 'eventos';

    protected $fillable = ['codigo','nome', 'local', 'data', 'status'];

    public $timestamps = true;
}

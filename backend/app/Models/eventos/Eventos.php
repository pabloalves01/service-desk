<?php

namespace App\Models\eventos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventos extends Model
{
    use SoftDeletes;
    protected $table = 'eventos';

    protected $fillable = ['codigo', 'nome', 'local', 'data', 'image_path', 'status'];

    public $timestamps = true;
}

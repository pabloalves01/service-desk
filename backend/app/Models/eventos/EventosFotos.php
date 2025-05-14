<?php

namespace App\Models\eventos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventosFotos extends Model
{
    use SoftDeletes;
    protected $table = 'eventos_fotos';
    protected $fillable = [
        'evento_id',
        'nome_remetente',
        'status',
        'image_path',
        'status',
    ];
    public $timestamps = true;
}

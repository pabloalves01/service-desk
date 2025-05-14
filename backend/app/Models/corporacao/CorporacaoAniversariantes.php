<?php

namespace App\Models\corporacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporacaoAniversariantes extends Model
{
    use SoftDeletes;
    protected $table = 'corporacao_aniversariantes';
    protected $fillable = [
        'nome',
        'setor_id',
        'dia',
        'mes',
    ];
    public $timestamps = true;
}

<?php

namespace App\Models\corporacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporacaoSetores extends Model
{
    use SoftDeletes;
    protected $table = 'corporacao_setores';
    protected $fillable = [
        'nome',
    ];
    public $timestamps = true;
}

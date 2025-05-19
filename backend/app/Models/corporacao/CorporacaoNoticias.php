<?php

namespace App\Models\corporacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporacaoNoticias extends Model
{
    use SoftDeletes;
    protected $table = 'corporacao_noticias';
    protected $fillable = [
        'titulo',
        'descricao',
    ];
    public $timestamps = true;
}

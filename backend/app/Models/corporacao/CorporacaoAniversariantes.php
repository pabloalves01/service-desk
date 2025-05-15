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
        'data_nascimento',
        'dia',
        'mes',
    ];
    public $timestamps = true;

    public function setor()
    {
        return $this->belongsTo(CorporacaoSetores::class, 'setor_id');
    }
}

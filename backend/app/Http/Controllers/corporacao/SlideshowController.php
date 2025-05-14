<?php

namespace App\Http\Controllers\corporacao;

use App\Http\Controllers\Controller;
use App\Models\corporacao\CorporacaoAniversariantes;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    public function getAniversariantes(Request $request)
    {
        $mes = $request->mes;

        $aniversariantes = CorporacaoAniversariantes::select('id', 'setor_id', 'nome', 'dia', 'mes')
            ->with([
                'setor' => function ($query) {
                    $query->select('id', 'nome as nome_setor');
                }
            ])
            ->where('mes', $mes)
            ->orderBy('dia', 'asc')
            ->get()
            ->map(function ($aniversariante) {
                return [
                    'nome' => $aniversariante->nome,
                    'dia' => $aniversariante->dia,
                    // 'mes' => $aniversariante->mes,
                    'departamento' => $aniversariante->setor->nome_setor ?? null,
                ];
            });

        return response()->json($aniversariantes);
    }
}

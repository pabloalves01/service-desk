<?php

namespace App\Http\Controllers\corporacao;

use App\Http\Controllers\Controller;
use App\Models\corporacao\CorporacaoAniversariantes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AniversariantesController extends Controller
{
    public function index()
    {
        $aniversariantes = CorporacaoAniversariantes::select('id', 'setor_id', 'data_nascimento', 'nome', 'dia', 'mes')
            ->with([
                'setor' => function ($query) {
                    $query->select('id', 'nome');
                }
            ])
            ->get()
            ->map(function ($aniversariante) {
                return [
                    'id' => $aniversariante->id,
                    'nome' => $aniversariante->nome,
                    'data_nascimento' => Carbon::parse($aniversariante->data_nascimento)->format('d/m/Y'),
                    'setor' => $aniversariante->setor->nome ?? null,
                ];
            });

        return response()->json([
            'message' => 'Lista de aniversariantes',
            'data' => $aniversariantes,
        ], 200);
    }
    public function store(Request $request)
    {
        $nome = $request->nome;
        $setor_id = $request->setor_id;
        $data_nascimento = Carbon::parse($request->data_nascimento)->format('Y-m-d');
        $dia = Carbon::parse($data_nascimento)->format('j');
        $mes = Carbon::parse($data_nascimento)->format('n');

        CorporacaoAniversariantes::create([
            'nome' => $nome,
            'setor_id' => $setor_id,
            'data_nascimento' => $data_nascimento,
            'dia' => $dia,
            'mes' => $mes,
        ]);

        return response()->json([
            'message' => 'Aniversariante adicionado com sucesso!',
            'data' => $request->all()
        ]);
    }

    public function destroy($id)
    {
        $aniversariante = CorporacaoAniversariantes::find($id);

        if (!$aniversariante) {
            return response()->json([
                'message' => 'Aniversariante não encontrado!'
            ], 404);
        }

        $aniversariante->delete();

        return response()->json([
            'message' => 'Aniversariante excluído com sucesso!'
        ]);
    }
}

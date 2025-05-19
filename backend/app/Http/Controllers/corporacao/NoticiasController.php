<?php

namespace App\Http\Controllers\corporacao;

use App\Http\Controllers\Controller;
use App\Models\corporacao\CorporacaoNoticias;
use Illuminate\Http\Request;

class NoticiasController extends Controller
{

    public function index()
    {
        $noticias = CorporacaoNoticias::all();

        return response()->json([
            'message' => 'Lista de notícias',
            'data' => $noticias,
        ]);
    }

    public function store(Request $request)
    {
        $titulo = $request->titulo;
        $descricao = $request->descricao;

        CorporacaoNoticias::create([
            'titulo' => $titulo,
            'descricao' => $descricao,
        ]);

        return response()->json([
            'message' => 'Notícia criada com sucesso!',
            'data' => [
                'titulo' => $titulo,
                'descricao' => $descricao,
            ],
        ]);
    }

    public function destroy($id)
    {
        $noticia = CorporacaoNoticias::find($id);

        if (!$noticia) {
            return response()->json([
                'message' => 'Notícia não encontrada',
            ], 404);
        }

        $noticia->delete();

        return response()->json([
            'message' => 'Notícia excluída com sucesso!',
        ]);
    }
}

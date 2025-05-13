<?php

namespace App\Http\Controllers\eventos;

use App\Http\Controllers\Controller;
use App\Models\eventos\Eventos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    public function index()
    {
        $eventos = Eventos::get(['codigo', 'nome', 'local', 'data', 'image_path', 'status']);
        foreach ($eventos as $evento) {
            $evento->data = Carbon::parse($evento->data)->format('d/m/Y H:i:s');
        }
        return response()->json([
            'message' => 'Lista de eventos',
            'data' => $eventos,
        ], 200);
    }

    public function store(Request $request)
    {
        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $file = $request->file('imagem');
            $codigo = $this->generateUniqueCode();
            $filename = 'imagem-capa-' . $codigo . '.' . $file->getClientOriginalExtension();
            $imagemPath = $file->storeAs('eventos', $filename, 'public');
        }

        $nome = $request->nome;
        $local = $request->local;
        $data_evento = Carbon::parse($request->data_evento)->format('Y-m-d H:i:s');

        $evento = Eventos::create([
            'codigo' => $codigo,
            'nome' => $nome,
            'local' => $local,
            'data' => $data_evento,
            'status' => 'ativo',
            'image_path' => $imagemPath,
        ]);

        return response()->json(['data' => $evento], 201);
    }


    private function generateUniqueCode()
    {
        do {
            $codigo = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Eventos::where('codigo', $codigo)->exists());

        return $codigo;
    }
}

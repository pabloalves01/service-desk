<?php

namespace App\Http\Controllers\eventos;

use App\Http\Controllers\Controller;
use App\Models\eventos\Eventos;
use App\Models\eventos\EventosFotos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    public function index()
    {
        $eventos = Eventos::get();
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

        return response()->json($evento, 201);
    }

    public function show($id)
    {
        $evento = Eventos::with('fotos')->find($id);
        if (!$evento) {
            return response()->json(['message' => 'Evento não encontrado'], 404);
        }

        $evento->data = Carbon::parse($evento->data)->format('d/m/Y H:i:s');

        return response()->json(['data' => $evento], 200);
    }


    private function generateUniqueCode()
    {
        do {
            $codigo = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Eventos::where('codigo', $codigo)->exists());

        return $codigo;
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'fotos' => 'required|array',
            'fotos.*' => 'file|mimes:jpg,jpeg,png,bmp,gif|max:10240',
        ]);

        $nome = $request->input('nome');
        $codigoEvento = $request->input('codigo');
        $fotos = $request->file('fotos');

        $evento = Eventos::where('codigo', $codigoEvento)->first();

        if ($fotos) {
            $caminhos = [];
            foreach ($fotos as $foto) {
                $codigo = $this->generateUniqueCode();
                $filename = $codigoEvento . 'foto-' . $codigo . '.' . $foto->getClientOriginalExtension();
                $caminho = $foto->storeAs('eventos/fotos', $filename, 'public');
                EventosFotos::create([
                    'evento_id' => $evento->id,
                    'nome_remetente' => $nome,
                    'image_path' => $caminho,
                ]);
                $caminhos[] = $caminho;
            }
        }
        return response()->json([
            'nome' => $nome,
            'fotos' => $caminhos ?? [],
        ], 200);
    }

    public function aprovar($id)
    {
        $fotosEvento = EventosFotos::find($id);
        if (!$fotosEvento) {
            return response()->json(['message' => 'Foto não encontrada'], 404);
        }
        $fotosEvento->status = 'aprovada';
        $fotosEvento->save();

        return response()->json([
            'message' => 'Foto aprovada com sucesso.',
        ], 200);
    }

    public function rejeitar($id)
    {
        $fotosEvento = EventosFotos::find($id);
        if (!$fotosEvento) {
            return response()->json(['message' => 'Foto não encontrada'], 404);
        }
        $fotosEvento->status = 'rejeitada';
        $fotosEvento->save();
        return response()->json([
            'message' => 'Foto rejeitada com sucesso.',
        ], 200);
    }

    public function excluir($id)
    {
        $fotosEvento = EventosFotos::find($id);
        if (!$fotosEvento) {
            return response()->json(['message' => 'Foto não encontrada'], 404);
        }
        $fotosEvento->delete();
        return response()->json([
            'message' => 'Foto excluída com sucesso.',
        ], 200);
    }

    public function imagensEvento($id)
    {
        $evento = Eventos::find($id);

        $fotosEvento = EventosFotos::where('evento_id', $evento->id)->where('status', 'aprovada')->get('image_path');

        if (!$fotosEvento) {
            return response()->json(['message' => 'Não foram encontradas fotos para esse evento..'], 404);
        }

        return response()->json([
            $fotosEvento,
        ], 200);
    }
}

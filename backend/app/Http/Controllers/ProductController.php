<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        return Produtos::all();
    }

    public function store(Request $request)
    {

        $nome = $request->nome;
        $preco = $request->preco;
        $quantidade = $request->quantidade;

        if (!$nome || !$preco || !$quantidade) {
            return response()->json([
                'error' => 'Todos os campos sao obrigatorios!'
            ], 422);
        }

        Produtos::create([
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ]);

        return response()->json([
            'message' => 'Produto criado com sucesso!'
        ], 200);
    }

    public function getProduto($id)
    {
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json([
                'error' => 'Produto nao encontrado!'
            ], 404);
        }

        return response()->json($produto, 200);
    }

    public function update($id) {
        Log::info('request', request()->all());
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json([
                'error' => 'Produto nao encontrado!'
            ], 404);
        }

        $produto->update([
            'nome' => request('nome'),
            'preco' => request('preco'),
            'quantidade' => request('quantidade')
        ]);

        return response()->json([
            'message' => 'Produto atualizado com sucesso!'
        ], 200);

    }

    public function destroy($id) {
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json([
                'error' => 'Produto nao encontrado!'
            ], 404);
        }

        $produto->delete();

        return response()->json([
            'message' => 'Produto deletado com sucesso!'
        ], 200);
    }
}

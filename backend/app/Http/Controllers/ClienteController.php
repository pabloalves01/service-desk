<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function store(Request $request) 
    {
        // return response()->json($request->all());
        $razao_social = $request->razao_social;
        $cnpj = $request->cnpj;
        
    
        // mudar validacao para o frontend 
        if (!$razao_social || !$cnpj) {
            return response()->json(['error' => "Todos os campos sao obrigatórios"], 422);
        }

        Clientes::create([
            'razao_social' => $razao_social,
            'cnpj' => $cnpj
        ]);
        
        return response()->json(['message' => 'Cliente cadastrado com sucesso!'], 200);
    }

    public function show()
    {
        $clientes = Clientes::all();
        return response()->json($clientes);
    }

    public function destroy($id) {

        $cliente = Clientes::find($id);

        // 422? verificar
        if (!$cliente) {
            return response()->json(['message' => "Cliente não encontrado"], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'cliente deletado com sucesso!'], 200);
    }

    public function getClient($id) {

        $cliente = Clientes::find($id);

        if (!$cliente) {
            return response()->json([
                "error" => "Cliente não encontrado,"
            ], 404);
        }

        return response()->json($cliente);
    }

    public function update(Request $request)
    {
        $razao_social = $request->razao_social;
        $cnpj = $request->cnpj;


        $cliente = Clientes::find($request->id);



        if (!$cliente) {
            return response()->json([
                "error" => "Cliente não encontrado,"
            ], 404);
        }

        $cliente->update([
            'razao_social' => $razao_social,
            'cnpj' => $cnpj
        ]);

        return response()->json(['message' => 'Cliente atualizado com sucesso!'], 200);


        return response()->json($cliente);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{

    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:clientes',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $cliente = Cliente::create($request->all());

        return response()->json($cliente, 201);
    }


    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente);
    }


    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }


        $validator = Validator::make($request->all(), [
            'nome' => 'string|max:255',
            'cpf' => 'string|max:14|unique:clientes,cpf,' . $id,
            'telefone' => 'string|max:15',
            'email' => 'email|max:255|unique:clientes,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $cliente->update($request->all());

        return response()->json($cliente);
    }


    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }
}

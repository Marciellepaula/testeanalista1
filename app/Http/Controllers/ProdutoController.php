<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    public function index()
    {
        $produto = Produto::all();
        return response()->json($produto);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:produto',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:produto',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $produto = Produto::create($request->all());

        return response()->json($produto, 201);
    }


    public function show($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'produto não encontrado'], 404);
        }

        return response()->json($produto);
    }


    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'produto não encontrado'], 404);
        }


        $validator = Validator::make($request->all(), [
            'nome' => 'string|max:255',
            'cpf' => 'string|max:14|unique:produtos,cpf,' . $id,
            'telefone' => 'string|max:15',
            'email' => 'email|max:255|unique:produtos,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $produto->update($request->all());

        return response()->json($produto);
    }


    public function destroy($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'produto não encontrado'], 404);
        }

        $produto->delete();

        return response()->json(['message' => 'produto excluído com sucesso']);
    }
}

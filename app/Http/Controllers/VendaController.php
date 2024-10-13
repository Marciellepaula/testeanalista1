<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendaController extends Controller
{
    public function index()
    {
        $clientes = Venda::all();
        return response()->json($clientes);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'cpf_cliente' => 'required|string|max:14|unique:vendas,cpf_cliente',
            'telefone_cliente' => 'required|string|max:15',
            'email_cliente' => 'required|string|email|max:255|unique:vendas,email_cliente',
            'produtos' => 'required|array',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'cupom_desconto' => 'nullable|numeric|min:0|max:100'
        ]);


        $venda = Venda::create([
            'nome_cliente' => $validated['nome_cliente'],
            'cpf_cliente' => $validated['cpf_cliente'],
            'telefone_cliente' => $validated['telefone_cliente'],
            'email_cliente' => $validated['email_cliente'],
            'total' => 0
        ]);


        $total = 0;
        foreach ($validated['produtos'] as $produto) {
            $produtoInfo = Produto::find($produto['id']);
            $subtotal = $produtoInfo->preco_venda * $produto['quantidade'];
            $total += $subtotal;

            $venda->produtos()->attach($produtoInfo->id, [
                'quantidade' => $produto['quantidade'],
                'preco_unitario' => $produtoInfo->preco_venda
            ]);
        }


        if ($request->has('cupom_desconto')) {
            $desconto = $total * ($validated['cupom_desconto'] / 100);
            $total -= $desconto;
        }


        $venda->update(['total' => $total]);


        Mail::to($venda->email_cliente)->queue(new VendaRealizada($venda));

        return redirect()->back()->with('success', 'Venda realizada com sucesso!');
    }

    public function show($id)
    {
        $cliente = Venda::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente);
    }


    public function update(Request $request, $id)
    {
        $cliente = Venda::find($id);

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
        $cliente = Venda::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }
}

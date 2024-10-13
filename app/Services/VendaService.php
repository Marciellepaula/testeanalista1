<?php

namespace App\Services;

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Validation\ValidationException;

class VendaService
{
    public function getAll()
    {
        return Venda::all();
    }

    public function create(array $data)
    {

        $validated = validator($data, [
            'nome_cliente' => 'required|string|max:255',
            'cpf_cliente' => 'required|string|max:14|unique:vendas,cpf_cliente',
            'telefone_cliente' => 'required|string|max:15',
            'email_cliente' => 'required|string|email|max:255|unique:vendas,email_cliente',
            'produtos' => 'required|array',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
            'cupom_desconto' => 'nullable|numeric|min:0|max:100'
        ]);

        if ($validated->fails()) {
            throw new ValidationException($validated);
        }


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


        if (isset($validated['cupom_desconto'])) {
            $desconto = $total * ($validated['cupom_desconto'] / 100);
            $total -= $desconto;
        }

        $venda->update(['total' => $total]);

        return $venda;
    }

    public function find($id)
    {
        return Venda::find($id);
    }

    public function update(Venda $venda, array $data)
    {
        $validated = validator($data, [
            'nome_cliente' => 'string|max:255',
            'cpf_cliente' => 'string|max:14|unique:vendas,cpf_cliente,' . $venda->id,
            'telefone_cliente' => 'string|max:15',
            'email_cliente' => 'email|max:255|unique:vendas,email_cliente,' . $venda->id,
        ]);

        if ($validated->fails()) {
            throw new ValidationException($validated);
        }

        $venda->update($validated->validated());

        return $venda;
    }

    public function delete(Venda $venda)
    {
        $venda->delete();
    }
}

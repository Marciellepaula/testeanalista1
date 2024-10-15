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

    public function create(array $data, $id)
    {

        logger($id);

        $venda = Venda::create([
            'cliente_id' => $id,
            'total' => 0
        ]);

        $total = 0;

        $produtos = json_decode($data['produtos'], true);
        foreach ($produtos as $produto) {
            $produtoInfo = Produto::find($produto['id']);
            $subtotal = $produtoInfo->preco_venda * $produto['quantidade'];
            $total += $subtotal;

            $venda->produtos()->attach($produtoInfo->id, [
                'quantidade' => $produto['quantidade'],
                'preco' => $produtoInfo->preco_venda
            ]);
        }


        if (isset($data['cupom_desconto'])) {
            $desconto = $total * ($data['cupom_desconto'] / 100);
            $total -= $desconto;
        }

        $venda->update(['total' => $total]);

        return $venda;
    }

    public function find($id)
    {
        return Venda::find($id);
    }

    public function update(Venda $venda)
    {
        $venda->update($venda->validated());

        return $venda;
    }

    public function delete(Venda $venda)
    {
        $venda->delete();
    }
}

<?php

namespace App\Services;

use App\Jobs\Vendas;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class VendaService
{
    public function getAll()
    {
        return Venda::all();
    }

    public function create(array $data, $id)
    {
        $venda = Venda::create([
            'cliente_id' => $id,
            'total' => 0,
            'codigo' =>  Str::uuid(),
            'status' => 'comprado'
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
            $produtoInfo->update([
                'quantidade' => $produtoInfo->quantidade - $produto['quantidade']
            ]);
        }



        if (isset($data['cupom_desconto'])) {
            $desconto = $total * ($data['cupom_desconto'] / 100);
            $total -= $desconto;
        }


        $venda->update(['total' => $total]);

        Vendas::dispatch($venda, $data['email']);

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

    public function getVendasCodigo($codigo)
    {
        return Venda::byCodigo($codigo);
    }


    public function getVendasAcimaDeTotal($total, $codigo)
    {
        return Venda::vendasAcimaDeTotal($total)->byCodigo($codigo)->with(['produtos', 'cliente'])->get();
    }


    public function getVendasEntreDatas($startDate, $endDate, $codigo)
    {
        return Venda::vendaEntreDatas($startDate, $endDate)->byCodigo($codigo)->with(['produtos', 'cliente'])->get();
    }

    public function getBuscaAvancada($inicio, $fim, $codigo, $total)
    {

        return Venda::with(['produtos', 'cliente'])
            ->byCodigo($codigo)
            ->vendasAcimaDeTotal($total)
            ->vendaEntreDatas('created_at', [$inicio, $fim])
            ->get();
    }
}

<?php

namespace App\Services;

use App\Jobs\Vendas;
use App\Models\Cupom;
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
            'codigo' => Str::uuid(),
            'status' => 'despachado',
            'quantidade' => 0
        ]);

        $total = 0;
        $quantidade = 0;

        $produtos = json_decode($data['produtos'], true);
        foreach ($produtos as $produto) {
            $produtoInfo = Produto::find($produto['id']);

            if (!$produtoInfo) {
                continue;
            }

            $subtotal = $produtoInfo->preco_venda * $produto['quantidade'];
            $quantidade += $produto['quantidade'];

            if ($produtoInfo->quantidade_estoque >= $produto['quantidade']) {
                $total += $subtotal;
                $venda->produtos()->attach($produtoInfo->id);

                $produtoInfo->update([
                    'quantidade_estoque' => $produtoInfo->quantidade_estoque - $produto['quantidade']
                ]);
            }
        }



        if ($data['desconto']) {
            $cupom =  Cupom::find($data['desconto']);
            if ($cupom->desconto_percentual) {
                $desconto = $total * ($cupom->desconto_percentual / 100);
                $total -= $desconto;
            }
            $cupom->update([
                'ativo' => false,
            ]);
        }
        $venda->update([
            'total' => $total,
            'quantidade' => $quantidade
        ]);

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
        return Venda::byCodigo($codigo)->get();
    }

    public function getVendasAcimaDeTotal($total, $codigo)
    {
        return Venda::vendasAcimaDeTotal($total)
            ->byCodigo($codigo)
            ->with(['produtos', 'cliente'])
            ->get();
    }

    public function getVendasEntreDatas($codigo, $startDate, $endDate,)
    {
        return Venda::vendaEntreDatas($startDate, $endDate)
            ->byCodigo($codigo)
            ->with(['produtos', 'cliente'])
            ->get();
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

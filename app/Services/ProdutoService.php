<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Support\Facades\Validator;

class ProdutoService
{

    public function getAll()
    {
        return Produto::all();
    }


    public function create(array $data)
    {

        if (isset($data['imagem']) && $data['imagem']->isValid()) {
            $path = $data['imagem']->store('images/produtos', 'public');
            $data['imagem'] = $path;
        } else {
            $data['imagem'] = null;
        }

        return Produto::create([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco_compra' => $data['preco_compra'],
            'preco_venda' => $data['preco_venda'],
            'quantidade_estoque' => $data['quantidade_estoque'],
            'imagem' => $data['imagem'],
            'categoria_id' => $data['categoria_id'],
        ]);
    }


    public function find($id)
    {
        return Produto::find($id);
    }


    public function update(Produto $produto, array $data)
    {


        $produto->update($data);

        return $produto;
    }


    public function delete(Produto $produto)
    {
        $produto->delete();
    }
}

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
        return Produto::create($data);
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

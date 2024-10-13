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
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:produtos',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:produtos',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return Produto::create($data);
    }


    public function find($id)
    {
        return Produto::find($id);
    }


    public function update(Produto $produto, array $data)
    {
        $validator = Validator::make($data, [
            'nome' => 'string|max:255',
            'cpf' => 'string|max:14|unique:produtos,cpf,' . $produto->id,
            'telefone' => 'string|max:15',
            'email' => 'email|max:255|unique:produtos,email,' . $produto->id,
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $produto->update($data);

        return $produto;
    }


    public function delete(Produto $produto)
    {
        $produto->delete();
    }
}

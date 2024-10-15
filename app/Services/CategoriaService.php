<?php

namespace App\Services;

use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoriaService
{

    public function getAll()
    {
        return Categoria::all();
    }


    public function create(array $data)
    {
        return Categoria::create($data);
    }


    public function find($id)
    {
        return Categoria::find($id);
    }


    public function update(Categoria $categoria, array $data)
    {

        $categoria->update($data);
        return $categoria;
    }


    public function delete(Categoria $categoria)
    {
        $categoria->delete();
    }
}

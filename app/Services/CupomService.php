<?php

namespace App\Services;

use App\Models\Cupom;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CupomService
{

    public function getAll()
    {
        return Cupom::all();
    }


    public function create(array $data)
    {
        return Cupom::create($data);
    }


    public function find($id)
    {
        return Cupom::find($id);
    }


    public function update(Cupom $cupom, array $data)
    {

        $cupom->update($data);
        return $cupom;
    }


    public function delete(Cupom $cupom)
    {
        $cupom->delete();
    }
}

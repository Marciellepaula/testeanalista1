<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ClienteService
{
    public function getAll()
    {
        return Cliente::all();
    }

    public function create(array $data)
    {

        return Cliente::create([
            'nome' => $data['nome'],
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
            'email' =>  $data['email']
        ]);
    }

    public function find($id)
    {
        return Cliente::find($id);
    }
    public function findClientebycpf($cpf)
    {
        return Cliente::where('cpf', '=', $cpf)->firstOrFail();
    }


    public function update(Cliente $cliente)
    {
        $cliente->update($cliente->validated());

        return $cliente;
    }

    public function delete(Cliente $cliente)
    {
        $cliente->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Cliente;
use Illuminate\Validation\ValidationException;

class ClienteService
{
    public function getAll()
    {
        return Cliente::all();
    }

    public function create(array $data)
    {

        $validated = validator($data, [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:clientes',
        ]);

        if ($validated->fails()) {
            throw new ValidationException($validated);
        }

        return Cliente::create($validated->validated());
    }

    public function find($id)
    {
        return Cliente::find($id);
    }

    public function update(Cliente $cliente, array $data)
    {
        $validated = validator($data, [
            'nome' => 'string|max:255',
            'cpf' => 'string|max:14|unique:clientes,cpf,' . $cliente->id,
            'telefone' => 'string|max:15',
            'email' => 'email|max:255|unique:clientes,email,' . $cliente->id,
        ]);

        if ($validated->fails()) {
            throw new ValidationException($validated);
        }

        $cliente->update($validated->validated());

        return $cliente;
    }

    public function delete(Cliente $cliente)
    {
        $cliente->delete();
    }
}

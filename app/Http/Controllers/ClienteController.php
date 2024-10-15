<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index()
    {
        $clientes = $this->clienteService->getAll();
        return response()->json($clientes);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);


        $user = $this->clienteService->create($validatedData);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $cliente = $this->clienteService->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {

        $cliente = $this->clienteService->find($id);


        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }


        $validated = $request->validate([
            'nome' => 'nullable|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:clientes,cpf,' . $id,
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $id,
        ]);

        try {
            $updatedCliente = $this->clienteService->update($cliente, $validated);
            return response()->json($updatedCliente);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }


    public function destroy($id)
    {
        $cliente = $this->clienteService->find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        $this->clienteService->delete($cliente);

        return response()->json(['message' => 'Cliente excluído com sucesso']);
    }
}

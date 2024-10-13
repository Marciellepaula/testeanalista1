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
        try {
            $cliente = $this->clienteService->create($request->all());
            return response()->json($cliente, 201);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
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

        try {
            $cliente = $this->clienteService->update($cliente, $request->all());
            return response()->json($cliente);
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

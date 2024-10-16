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
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {

            $cliente = $this->clienteService->create($validatedData);
            return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso!');
        } catch (ValidationException $e) {

            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function show($id)
    {
        $cliente = $this->clienteService->find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->withErrors(['message' => 'Cliente não encontrado']);
        }

        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = $this->clienteService->find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->withErrors(['message' => 'Cliente não encontrado']);
        }

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = $this->clienteService->find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->withErrors(['message' => 'Cliente não encontrado']);
        }


        $validated = $request->validate([
            'nome' => 'nullable|string|max:255',
            'cpf' => 'nullable|string|max:14|unique:clientes,cpf,' . $id,
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $id,
        ]);

        try {
            $updatedCliente = $this->clienteService->update($cliente, $validated);
            return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function destroy($id)
    {
        $cliente = $this->clienteService->find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->withErrors(['message' => 'Cliente não encontrado']);
        }

        $this->clienteService->delete($cliente);

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!'); // Redirect with success message
    }
}

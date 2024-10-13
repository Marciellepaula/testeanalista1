<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Services\VendaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendaRealizada;
use Illuminate\Validation\ValidationException;

class VendaController extends Controller
{
    protected $vendaService;

    public function __construct(VendaService $vendaService)
    {
        $this->vendaService = $vendaService;
    }

    public function index()
    {
        $vendas = $this->vendaService->getAll();
        return response()->json($vendas);
    }

    public function store(Request $request)
    {
        try {
            $venda = $this->vendaService->create($request->all());


            Mail::to($venda->email_cliente)->queue(new VendaRealizada($venda));

            return response()->json($venda, 201);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function show($id)
    {
        $venda = $this->vendaService->find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        return response()->json($venda);
    }

    public function update(Request $request, $id)
    {
        $venda = $this->vendaService->find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        try {
            $venda = $this->vendaService->update($venda, $request->all());
            return response()->json($venda);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function destroy($id)
    {
        $venda = $this->vendaService->find($id);

        if (!$venda) {
            return response()->json(['message' => 'Venda não encontrada'], 404);
        }

        $this->vendaService->delete($venda);

        return response()->json(['message' => 'Venda excluída com sucesso']);
    }
}

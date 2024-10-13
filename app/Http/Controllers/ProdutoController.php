<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function index()
    {
        $produtos = $this->produtoService->getAll();
        return response()->json($produtos);
    }

    public function store(Request $request)
    {
        try {
            $produto = $this->produtoService->create($request->all());
            return response()->json($produto, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function show($id)
    {
        $produto = $this->produtoService->find($id);

        if (!$produto) {
            return response()->json(['message' => 'produto não encontrado'], 404);
        }

        return response()->json($produto);
    }

    public function update(Request $request, $id)
    {
        $produto = $this->produtoService->find($id);

        if (!$produto) {
            return response()->json(['message' => 'produto não encontrado'], 404);
        }

        try {
            $produto = $this->produtoService->update($produto, $request->all());
            return response()->json($produto);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function destroy($id)
    {
        $produto = $this->produtoService->find($id);

        if (!$produto) {
            return response()->json(['message' => 'produto não encontrado'], 404);
        }

        $this->produtoService->delete($produto);

        return response()->json(['message' => 'produto excluído com sucesso']);
    }
}

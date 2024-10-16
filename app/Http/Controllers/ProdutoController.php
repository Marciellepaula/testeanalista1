<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $categorias = Categoria::all();
        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:14|unique:produtos,descricao',
            'preco_compra' => 'required|numeric|max:999999.99',
            'preco_venda' => 'required|numeric|max:999999.99',
            'quantidade_estoque' => 'required|integer|min:0',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        try {

            $produto = $this->produtoService->create($validatedData);

            return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'Erro ao criar produto: ' . $e->getMessage()])->withInput();
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
            return redirect()->route('produtos.index')->withErrors(['message' => 'Produto não encontrado']);
        }

        $this->produtoService->delete($produto);

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}

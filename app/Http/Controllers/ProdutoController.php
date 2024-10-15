<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $auth = Auth::attempt();
        $categorias = Categoria::all();
        return view('produtos.create', compact('categorias'));
    }
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|unique:produtos,cpf',
                'telefone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255|unique:produtos,email',
            ]);


            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }


            $produto = $this->produtoService->create($validator->validated());


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

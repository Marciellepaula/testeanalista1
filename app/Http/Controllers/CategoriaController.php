<?php


namespace App\Http\Controllers;

use App\Services\CategoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    protected $categoriaService;

    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    public function index()
    {
        $categorias = $this->categoriaService->getAll();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:categorias',
            'descricao' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        try {
            $categoria = $this->categoriaService->create($request->all());
            return response()->json($categoria, 201);
        } catch (ValidationException $e) {
            return response()->json($e->validator->errors(), 422);
        }
    }

    public function show($id)
    {
        $categoria = $this->categoriaService->find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        return response()->json($categoria);
    }

    public function update(Request $request, $id)
    {
        $categoria = $this->categoriaService->find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }


        $validator = Validator::make($request->all(), [
            'nome' => 'string|max:255|unique:categorias,nome,' . $categoria->id,
            'descricao' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $updatedCategoria = $this->categoriaService->update($categoria, $request->only('nome', 'descricao'));
        return response()->json($updatedCategoria);
    }

    public function destroy($id)
    {
        $categoria = $this->categoriaService->find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        $this->categoriaService->delete($categoria);
        return response()->json(['message' => 'Categoria excluída com sucesso']);
    }
}

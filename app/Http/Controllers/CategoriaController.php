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
        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:categorias',
            'descricao' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $categoria = $this->categoriaService->create($request->all());
            return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
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
        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
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

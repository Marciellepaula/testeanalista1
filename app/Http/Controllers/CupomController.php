<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use App\Services\CupomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CupomController extends Controller
{
    protected $cupomService;

    public function __construct(CupomService $cupomService)
    {
        $this->cupomService = $cupomService;
    }

    public function index()
    {
        $cupons = $this->cupomService->getAll();
        return view('cupons.index', compact('cupons'));
    }

    public function create()
    {
        return view('cupons.create');
    }

    public function store(Request $request)
    {


        $validator = $request->validate([
            'codigo' => 'required|string|max:50|unique:cupons,codigo',
            'desconto_percentual' => 'nullable|numeric|min:0|max:100',
            'ativo' => 'required|boolean',
            'data_inicio' => 'nullable|date|before:data_fim',
            'data_fim' => 'nullable|date|after:data_inicio',
        ]);

        if (!$validator) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cupom = $this->cupomService->create($validator);
        return redirect()->route('cupons.index')->with('success', 'Cupom criado com sucesso!');
    }

    public function show(Cupom $cupom)
    {
        return view('cupons.show', compact('cupom'));
    }

    public function edit(Cupom $cupom)
    {
        return view('cupons.edit', compact('cupom'));
    }

    public function update(Request $request, Cupom $cupom)
    {
        $validator = $request->validate([
            'codigo' => 'sometimes|required|string|max:50|unique:cupons,codigo,' . $cupom->id,
            'desconto_percentual' => 'sometimes|nullable|numeric|min:0|max:100',
            'ativo' => 'sometimes|required|boolean',
            'data_inicio' => 'sometimes|nullable|date|before:data_fim',
            'data_fim' => 'sometimes|nullable|date|after:data_inicio',
        ]);

        if ($validator) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->cupomService->update($cupom, $validator);
        return redirect()->route('cupons.index')->with('success', 'Cupom atualizado com sucesso!');
    }

    public function destroy(Cupom $cupom)
    {
        $this->cupomService->delete($cupom);
        return redirect()->route('cupons.index')->with('success', 'Cupom deletado com sucesso!');
    }
}

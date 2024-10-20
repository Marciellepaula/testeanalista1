<?php

namespace App\Http\Controllers;

use App\Services\VendaService;
use Illuminate\Http\Request;
use App\Services\ClienteService;
use App\Services\CupomService;
use App\Services\ProdutoService;
use Illuminate\Validation\ValidationException;

class VendaController extends Controller
{
    protected $vendaService;
    protected $produtoService;
    protected $cupomService;
    protected $clienteService;


    public function __construct(VendaService $vendaService, ProdutoService $produtoService, CupomService  $cupomService, ClienteService $clienteService)
    {
        $this->vendaService = $vendaService;
        $this->produtoService = $produtoService;
        $this->cupomService = $cupomService;
        $this->clienteService = $clienteService;
    }


    public function index()
    {
        $vendas = $this->vendaService->getAll();
        return view('venda.index', compact('vendas'));
    }


    public function create()
    {
        $cupons = $this->cupomService->getAll();
        $produtos = $this->produtoService->getAll();
        return view('dashboard', compact('produtos', 'cupons'));
    }

    public function store(Request $request)
    {

        try {

            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:14',
                'telefone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255',
                'produtos' => 'required|json',
                'produtos.*.id' => 'required|integer|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
                'desconto' => 'nullable|numeric|min:0',
            ]);


            $cliente = $this->clienteService->findClientebycpf($request->cpf);

            if (!$cliente) {
                $cliente = $this->clienteService->create($validated);
            }

            $venda = $this->vendaService->create($validated, $cliente->id);

            return redirect()->back()->with('success', 'Produto comprado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function show($id)
    {
        $venda = $this->vendaService->find($id);

        if (!$venda) {
            return redirect()->back()->withErrors(['error' => 'Erro ao comprar o produto.']);
        }


        return redirect()->back()->with('success', 'Produto comprado com sucesso!');
    }
}

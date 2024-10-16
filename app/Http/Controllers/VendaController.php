<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Services\VendaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendaRealizada;
use App\Services\ClienteService;
use App\Services\CupomService;
use App\Services\ProdutoService;
use Illuminate\Support\Facades\Validator;
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
        return view('venda.produtos', compact('produtos', 'cupons'));
    }

    public function store(Request $request)
    {

        try {

            logger($request);
            $validated =  $request->validate($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:14',
                'telefone' => 'required|string|max:15',
                'email' => 'required|string|email|max:255|unique:clientes,email',
                'produtos' => 'required|json',
                'produtos.*.id' => 'required|exists:produtos,id',
                'produtos.*.quantidade' => 'required|integer|min:1',
                'cupom_desconto' => 'nullable|numeric|min:0|max:100'
            ]);


            if ($validated) {
                throw new ValidationException($validated);
            }

            $cliente = $this->clienteService->create($validated);
            $venda = $this->vendaService->create($validated, $cliente->id);
            Mail::to($cliente->email)->queue(new VendaRealizada($venda));


            return redirect()->route('venda.index')->with('success', 'Produto comprado com sucesso!');
        } catch (ValidationException $e) {

            return response()->json($e->validator->errors(), 422);
        } catch (\Exception $e) {

            logger()->error('Error creating venda: ' . $e->getMessage());


            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
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

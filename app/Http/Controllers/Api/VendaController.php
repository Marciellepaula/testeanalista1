<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ClienteService;
use App\Services\CupomService;
use App\Services\ProdutoService;
use App\Services\VendaService;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

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
        return response()->json($vendas);
    }


    public function vendasPorCliente($clienteId)
    {
        $vendasDoCliente = $this->vendaService->getVendasPorCliente($clienteId);
        return response()->json($vendasDoCliente);
    }


    public function vendasAcimaDeTotal($total)
    {
        $vendasAcimaDeMil = $this->vendaService->getVendasAcimaDeTotal($total);
        return response()->json($vendasAcimaDeMil);
    }


    public function vendasEntreDatas(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $vendasEntreDatas = $this->vendaService->getVendasEntreDatas($startDate, $endDate);
        return response()->json($vendasEntreDatas);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ClienteService;
use App\Services\CupomService;
use App\Services\ProdutoService;
use App\Services\VendaService;
use Illuminate\Http\Request;


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


    public function vendasCodigo($codigo)
    {
        $vendascodigo = $this->vendaService->getVendasCodigo($codigo);
        return response()->json($vendascodigo);
    }

    public function vendasAcimaDeTotal(Request $request)
    {
        $total = $request->input('total');
        $codigo = $request->input('codigo');

        $vendasAcima = $this->vendaService->getVendasAcimaDeTotal($total, $codigo);
        return response()->json($vendasAcima);
    }

    public function vendasEntreDatas($codigo, $startDate, $endDate)
    {
        $vendasEntreDatas = $this->vendaService->getVendasEntreDatas($codigo, $startDate, $endDate);
        return response()->json($vendasEntreDatas);
    }

    public function buscaAvancada($inicio, $fim, $codigo, $total)
    {
        $vendasAvancadas = $this->vendaService->getBuscaAvancada($inicio, $fim, $codigo, $total);
        return response()->json($vendasAvancadas);
    }
}

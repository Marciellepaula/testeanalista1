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

    public function vendasEntreDatas(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $codigo = $request->input('codigo');

        $vendasEntreDatas = $this->vendaService->getVendasEntreDatas($startDate, $endDate, $codigo);
        return response()->json($vendasEntreDatas);
    }

    public function buscaAvancada(Request $request)
    {
        $inicio = $request->input('inicio');
        $fim = $request->input('fim');
        $codigo = $request->input('codigo');
        $total = $request->input('total');

        $vendasAvancadas = $this->vendaService->getBuscaAvancada($inicio, $fim, $codigo, $total);
        return response()->json($vendasAvancadas);
    }
}

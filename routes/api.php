<?php

use App\Http\Controllers\Api\VendaController;
use Illuminate\Support\Facades\Route;



Route::get('/vendas/cliente/{codigo}', [VendaController::class, 'vendasCodigo']);
Route::get('/vendas/acima-total/', [VendaController::class, 'vendasAcimaDeTotal']);
Route::get('/vendas/busca-avancada/', [VendaController::class, 'buscaAvancada']);

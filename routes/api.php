<?php

use App\Http\Controllers\Api\VendaController;
use Illuminate\Support\Facades\Route;



Route::get('/vendas/cliente/{codigo}', [VendaController::class, 'vendasCodigo']);
Route::get('/vendas/cliente/total/{total}', [VendaController::class, 'vendasAcimaDeTotal']);
Route::get('/vendas/cliente/data/{codigo}/{dataInicial}/{dataFinal}', [VendaController::class, 'vendasEntreDatas']);
Route::get('/vendas/cliente/{total}/{dataInicial/{dataFinal}', [VendaController::class, 'buscaAvancada']);

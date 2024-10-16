<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\VendaProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produto/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produto', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::get('/produto/{id}', [ProdutoController::class, 'show']);
    Route::put('/produto/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produto/{id}', [ProdutoController::class, 'destroy']);
    Route::get('/vendas/create', [VendaController::class, 'create']);
    Route::get('vendas/', [VendaController::class, 'index'])->name('venda');
    Route::post('vendas/produtos/', [VendaController::class, 'store'])->name('venda.store');
});



Route::get('clientes', [ClienteController::class, 'index']);
Route::post('clientes', [ClienteController::class, 'store']);
Route::get('clientes/{id}', [ClienteController::class, 'show']);
Route::put('clientes/{id}', [ClienteController::class, 'update']);
Route::delete('clientes/{id}', [ClienteController::class, 'destroy']);




Route::get('vendas/{vendaId}/produtos', [VendaController::class, 'index']);
Route::put('vendas/{vendaId}/produtos/{produtoId}', [VendaController::class, 'update']);
Route::delete('vendas/{vendaId}/produtos/{produtoId}', [VendaController::class, 'destroy']);
require __DIR__ . '/auth.php';

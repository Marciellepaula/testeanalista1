<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [VendaController::class, 'create'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/produto/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produto', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produto/{id}', [ProdutoController::class, 'show']);
    Route::put('/produto/{id}', [ProdutoController::class, 'update']);
    Route::delete('/produto/{id}', [ProdutoController::class, 'destroy']);

    Route::get('vendas/', [VendaController::class, 'index'])->name('venda');
    Route::post('vendas/produtos/', [VendaController::class, 'store'])->name('venda.store');
    Route::get('vendas/{vendaId}/produtos', [VendaController::class, 'index']);
    Route::put('vendas/{vendaId}/produtos/{produtoId}', [VendaController::class, 'update']);
    Route::delete('vendas/{vendaId}/produtos/{produtoId}', [VendaController::class, 'destroy']);

    Route::get('clientes', [ClienteController::class, 'index']);
    Route::post('clientes', [ClienteController::class, 'store']);
    Route::get('clientes/{id}', [ClienteController::class, 'show']);
    Route::put('clientes/{id}', [ClienteController::class, 'update']);
    Route::delete('clientes/{id}', [ClienteController::class, 'destroy']);


    Route::get('/categoria', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
    Route::post('/categoria', [CategoriaController::class, 'store'])->name('categoria.store');
    Route::get('categoria/{id}', [CategoriaController::class, 'show'])->name('categoria.show');
    Route::put('categoria/{id}', [CategoriaController::class, 'update'])->name('categoria.upadate');
    Route::delete('categoria/{id}', [CategoriaController::class, 'destroy']);
});








require __DIR__ . '/auth.php';

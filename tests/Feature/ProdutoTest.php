<?php

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{post, actingAs, assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('can create a produto', function () {
    $user = User::factory()->create();
    actingAs($user);

    $categoria = Categoria::factory()->create();

    $response = post(route('produtos.store'), [
        'nome' => 'Produto Teste',
        'descricao' => 'Descrição',
        'preco_compra' => 100.00,
        'preco_venda' => 150.00,
        'quantidade_estoque' => 10,
        'categoria_id' => $categoria->id,
    ]);

    $response->assertRedirect(route('produtos.index'));
    $response->assertSessionHas('success', 'Produto criado com sucesso!');
    assertDatabaseHas('produtos', [
        'nome' => 'Produto Teste',
        'descricao' => 'Descrição',
        'preco_compra' => 100.00,
        'preco_venda' => 150.00,
        'quantidade_estoque' => 10,
        'categoria_id' => $categoria->id,
    ]);
});

it('validates required fields when creating produto', function () {
    $user = User::factory()->create();
    actingAs($user);

    $categoria = Categoria::factory()->create();

    $response = post(route('produtos.store'), [
        'nome' => '',
        'descricao' => 'Descrição Teste',
        'preco_compra' => 100.00,
        'preco_venda' => 150.00,
        'quantidade_estoque' => 10,
        'categoria_id' => $categoria->id,
    ]);

    $response->assertSessionHasErrors(['nome']);
    assertDatabaseMissing('produtos', ['descricao' => 'Descrição Teste']);
});

it('handles exceptions when creating produto', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = post(route('produtos.store'), [
        'nome' => 'Produto Teste',
        'descricao' => 'Descrição Teste',
        'preco_compra' => 100.00,
        'preco_venda' => 150.00,
        'quantidade_estoque' => -1,
        'categoria_id' => 9999,
    ]);

    $response->assertRedirect()->withErrors(['message' => 'Erro ao criar produto:']);
});

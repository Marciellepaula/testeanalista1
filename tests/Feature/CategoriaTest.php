<?php

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{post, put, actingAs, assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('can create a categoria', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = post(route('categoria.store'), [
        'nome' => 'Categoria Teste',
        'descricao' => 'Descrição Teste',
    ]);

    $response->assertRedirect(route('categoria.index'));
    $response->assertSessionHas('success', 'Categoria criada com sucesso!');
    assertDatabaseHas('categorias', [
        'nome' => 'Categoria Teste',
        'descricao' => 'Descrição Teste',
    ]);
});

it('validates required fields when creating categoria', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = post(route('categoria.store'), [
        'nome' => '',
        'descricao' => 'Descrição Teste',
    ]);

    $response->assertSessionHasErrors(['nome']);
    assertDatabaseMissing('categorias', ['descricao' => 'Descrição Teste']);
});

it('can update a categoria', function () {
    $user = User::factory()->create();
    actingAs($user);

    $categoria = Categoria::create([
        'nome' => 'Old Name',
        'descricao' => 'Old Description',
    ]);

    $response = put(route('categoria.update', $categoria->id), [
        'nome' => 'Updated Name',
        'descricao' => 'Updated Description',
    ]);

    $response->assertRedirect(route('categoria.index'));
    assertDatabaseHas('categorias', [
        'id' => $categoria->id,
        'nome' => 'Updated Name',
        'descricao' => 'Updated Description',
    ]);
});

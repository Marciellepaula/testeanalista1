<?php

use App\Jobs\Vendas;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->clienteData = [
        'nome' => 'Cliente Teste',
        'cpf' => '123.456.789-00',
        'telefone' => '99999-9999',
        'email' => 'cliente@teste.com'
    ];


    $this->cliente = Cliente::factory()->create($this->clienteData);

    $this->produto = Produto::factory()->create([
        'nome' => 'Produto Teste',
        'preco_venda' => 100.00,
        'quantidade_estoque' => 50
    ]);
});

it('can create a venda with valid data', function () {

    $vendaData = [
        'nome' => $this->cliente->nome,
        'cpf' => $this->cliente->cpf,
        'telefone' => $this->cliente->telefone,
        'email' => $this->cliente->email,
        'produtos' => json_encode([
            ['id' => $this->produto->id, 'quantidade' => 2]
        ]),
        'cupom_desconto' => 10
    ];


    $response = $this->post(route('venda.store', $this->cliente->id), $vendaData);

    $venda = Venda::first();

    expect($venda)->not->toBeNull();
    expect($venda->cliente_id)->toBe($this->cliente->id);
    expect($venda->total)->toBe(180.00);
    expect($venda->quantidade)->toBe(2);


    $this->assertDatabaseHas('produtos', [
        'id' => $this->produto->id,
        'quantidade_estoque' => 48,
    ]);


    expect($venda->produtos->count())->toBe(1);
    expect($venda->produtos->first()->id)->toBe($this->produto->id);

    $this->assertDispatched(Vendas::class, function ($job) use ($venda, $vendaData) {
        return $job->venda->id === $venda->id && $job->email === $vendaData['email'];
    });

    $response = $this->post(route('venda.store'), $vendaData);

    $response->assertRedirect()->with('success', 'Produto comprado com sucesso!');


    $this->assertDatabaseHas('vendas', [
        'cliente_id' => $this->cliente->id,
        'total' => 180.00,
    ]);


    $this->assertDatabaseHas('produtos', [
        'id' => $this->produto->id,
        'quantidade_estoque' => 48,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/dashboard');
});

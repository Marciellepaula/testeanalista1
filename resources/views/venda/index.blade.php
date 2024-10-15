
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Vendas</h1>

    <table class="table-auto w-full text-left">
        <thead>
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Cliente ID</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Data de Criação</th>
                <th class="px-4 py-2">Data de Atualização</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $venda['id'] }}</td>
                    <td class="px-4 py-2">{{ $venda['cliente_id'] }}</td>
                    <td class="px-4 py-2">R$ {{ number_format($venda['total'], 2, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($venda['created_at'])->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($venda['updated_at'])->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

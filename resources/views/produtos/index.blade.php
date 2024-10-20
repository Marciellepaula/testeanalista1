@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Produtos</h1>
        <div class="flex justify-end">
            <a href="{{ route('produtos.create') }}"
                class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded">
                Criar produto
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Nome</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Preço de Venda</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Descrição</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Quantidade em Estoque</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Imagen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($produtos as $produto)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-900">{{ $produto->nome }}</td>
                            <td class="py-4 px-6 text-gray-900">R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-gray-600">{{ $produto->descricao }}</td>
                            <td class="py-4 px-6 text-gray-900">{{ $produto->quantidade_estoque }}</td>
                            @if ($produto->imagem)
                                <td>
                                    <img src="{{ asset('storage/' . $produto->imagem) }}" alt="Imagem"
                                        class="w-16 h-16 object-cover">
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

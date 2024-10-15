@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Cadastrar Produto</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 border border-red-400 px-4 py-3 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <!-- Nome do Produto -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nome do Produto</label>
            <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <!-- Descrição -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <!-- Preço de Compra -->
        <div class="mb-4">
            <label for="purchase_price" class="block text-sm font-medium text-gray-700">Preço de Compra</label>
            <input type="number" step="0.01" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" required>
        </div>

        <!-- Preço de Venda -->
        <div class="mb-4">
            <label for="sale_price" class="block text-sm font-medium text-gray-700">Preço de Venda</label>
            <input type="number" step="0.01" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" required>
        </div>

        <!-- Categoria -->
        <div class="mb-4">
            <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoria</label>
            <select class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="categoria_id" name="categoria_id" required>
                <option value="">Selecione uma Categoria</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Quantidade em Estoque -->
        <div class="mb-4">
            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Quantidade em Estoque</label>
            <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
        </div>

        <!-- Imagem -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Imagem do Produto</label>
            <input type="file" class="mt-1 block w-full text-gray-500 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="image" name="image">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Cadastrar Produto
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Gerenciamento de Categorias</h1>




        <div class="">

            <form method="POST" action="{{ route('categoria.store') }}">
                @csrf
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="nome" id="nome" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mt-4">
                    <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                    <textarea name="descricao" id="descricao"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="mt-4">
                    <x-button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Salvar</x-button>
                </div>
            </form>

        </div>
    </div>
@endsection

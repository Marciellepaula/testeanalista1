<!-- resources/views/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Gerenciamento de Categorias</h1>

        <x-button class="mt-4" href="#modal">Adicionar Categoria</x-button>

        <!-- Modal -->
        <div id="modal" class="hidden">
            <x-modal title="Adicionar Categoria">
                <form method="POST" action="{{ route('categorias.store') }}">
                    @csrf
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" name="nome" id="nome" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mt-4">
                        <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea name="descricao" id="descricao" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div class="mt-4">
                        <x-button type="submit">Salvar</x-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>

    <script>
        document.querySelector('x-button[href="#modal"]').addEventListener('click', function () {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.querySelector('#modal button').addEventListener('click', function () {
            document.getElementById('modal').classList.add('hidden');
        });
    </script>
@endsection

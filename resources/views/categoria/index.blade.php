@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Categoria</h1>
        <div class="flex justify-end">
            <a href="{{ route('categoria.create') }}"
                class="inline-block px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded">
                Criar Categoria
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Nome</th>
                        <th class="py-3 px-6 text-left font-medium text-gray-700">Descricao</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($categorias as $categoria)
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-900">{{ $categoria->nome }}</td>
                            <td class="py-4 px-6 text-gray-600">{{ $categoria->descricao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

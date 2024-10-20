@props(['produtos'])

<div id="addToCartModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
    <div class="bg-white p-4 rounded-lg">
        <h2 class="text-lg font-semibold" id="modalProductName">Adicionar ao Carrinho</h2>
        <select id="product" class="mt-2 border rounded p-2">
            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}" data-preco="{{ $produto->preco_venda }}"
                    data-quantidade_estoque="{{ $produto->quantidade_estoque }}">
                    {{ $produto->nome }}
                </option>
            @endforeach
        </select>

        <input id="quantidade" type="number" class="mt-2 border rounded p-2" placeholder="Quantidade" min="1">
        <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded" onclick="addToCart()">Adicionar</button>
        <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded" onclick="closeAddToCartModal()">Fechar</button>
    </div>
</div>

@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Venda de Produtos</h1>


        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Informações do Cliente</h2>
            <form id="saleForm" action="{{ route('venda.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-3">
                        <label for="nome" class="block text-gray-700">Nome do Cliente</label>
                        <input type="text" id="nome" name="nome" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="block text-gray-700">CPF</label>
                        <input type="text" id="cpf" name="cpf" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="block text-gray-700">Telefone</label>
                        <input type="text" id="telefone" name="telefone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                </div>
                <input type="hidden" id="produtosInput" name="produtos">
            </form>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($produtos as $produto)
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img class="h-auto max-w-full" src="{{ $produto->img }}" alt="{{ $produto->nome }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $produto->nome }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>



                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-semibold mb-4">Carrinho de Produtos</h2>
                    <table class="min-w-full bg-white border rounded-lg shadow-sm" id="cartTable">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-6 text-left font-medium text-gray-700">Produto</th>
                                <th class="py-3 px-6 text-left font-medium text-gray-700">Preço Unitário</th>
                                <th class="py-3 px-6 text-left font-medium text-gray-700">Quantidade</th>
                                <th class="py-3 px-6 text-left font-medium text-gray-700">Subtotal</th>
                                <th class="py-3 px-6 text-left font-medium text-gray-700">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="cartItems">
                        </tbody>
                    </table>
                </div>


                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <h2 class="text-xl font-semibold mb-4">Aplicar Cupom de Desconto</h2>
                    <div class="flex items-center">
                        <input type="text" id="coupon_code" name="coupon_code" placeholder="Insira o cupom" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="button" onclick="applyDiscount()" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:bg-blue-700">Aplicar</button>
                    </div>
                    <p id="discountMessage" class="mt-2 text-green-600"></p>
                    <h3 class="mt-4 text-lg font-semibold">Cupons Disponíveis:</h3>
                    <ul class="mt-2">
                        @foreach ($cupons as $cupom)
                            <li class="text-gray-800">- {{ $cupom->codigo }}: {{ $cupom->descricao }} (Desconto:  {{ $cupom->desconto_percentual }}%)</li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Resumo da Venda</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-lg font-medium text-gray-700">Subtotal:</div>
                        <div class="text-lg font-medium text-gray-900" id="subtotalAmount">R$ 0,00</div>

                        <div class="text-lg font-medium text-gray-700">Desconto:</div>
                        <div id="discountAmount" class="text-lg font-medium text-gray-900">R$ 0,00</div>

                        <div class="text-lg font-bold text-gray-700">Total:</div>
                        <div id="totalAmount" class="text-lg font-bold text-gray-900">R$ 0,00</div>
                    </div>
                </div>


                <div class="mt-6">
                    <button type="submit" form="saleForm" class="w-full py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 focus:outline-none focus:bg-green-700">Finalizar Venda</button>
                </div>

        </div>
    </div>

    <script>
        document.getElementById('saleForm').addEventListener('submit', function(event) {
        event.preventDefault();

        event.preventDefault();


        const produtosInput = document.getElementById('produtosInput');
        produtosInput.value = JSON.stringify(cart);


        this.submit();
         });

        let cart = [];

        function addToCart() {
            const productSelect = document.getElementById('product');
            const quantityInput = document.getElementById('quantidade');


            const productId = productSelect.value;
            const productName = productSelect.options[productSelect.selectedIndex].text;
            const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price);
            const quantity = parseInt(quantityInput.value);


            if (productId && quantity > 0) {
                const subtotal = productPrice * quantity;
                cart.push({  id: productId, quantidade: quantity,  price: productPrice, name: productName,  subtotal: subtotal });

                renderCart();
                updateTotals();
                productSelect.value = "";
                quantityInput.value = "";
            }
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            renderCart();
            updateTotals();
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';
            cart.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="py-4 px-6 text-gray-900">${item.name}</td>
                    <td class="py-4 px-6 text-gray-900">R$ ${item.price.toFixed(2).replace('.', ',')}</td>
                    <td class="py-4 px-6 text-gray-900">${item.quantidade}</td>
                    <td class="py-4 px-6 text-gray-900">R$ ${item.subtotal.toFixed(2).replace('.', ',')}</td>
                    <td class="py-4 px-6 text-gray-900">
                        <button type="button" onclick="removeFromCart(${index})" class="text-red-600 hover:text-red-900">Remover</button>
                    </td>
                `;
                cartItems.appendChild(row);
            });
        }

        function updateTotals() {
            const subtotal = cart.reduce((acc, item) => acc + item.subtotal, 0);
            const discount = parseFloat(document.getElementById('discountAmount').innerText.replace('R$ ', '').replace(',', '.')) || 0;
            const total = subtotal - discount;

            document.getElementById('subtotalAmount').innerText = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
            document.getElementById('totalAmount').innerText = `R$ ${total.toFixed(2).replace('.', ',')}`;
        }

        function applyDiscount() {
            const discountCode = document.getElementById('coupon_code').value;
            const discountMessage = document.getElementById('discountMessage');
            const subtotal = cart.reduce((acc, item) => acc + item.subtotal, 0);
            let discount = 0;

            @foreach ($cupons as $cupom)
                if (discountCode === '{{ $cupom->codigo }}') {
                    discount = {{ $cupom->desconto_percentual }};
                }
            @endforeach

            if (discount > 0) {
                const discountAmount = (subtotal * (discount / 100)).toFixed(2);
                document.getElementById('discountAmount').innerText = `R$ ${discountAmount.replace('.', ',')}`;
                discountMessage.innerText = `Desconto aplicado: ${discount}%`;
            } else {
                discountMessage.innerText = 'Cupom inválido ou já utilizado.';
            }

            updateTotals();
        }
    </script>
@endsection


{{-- <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-6.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-7.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-8.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-9.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-10.jpg" alt="">
    </div>
    <div>
        <img class="h-auto max-w-full rounded-lg" src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-11.jpg" alt="">
    </div>
</div> --}}

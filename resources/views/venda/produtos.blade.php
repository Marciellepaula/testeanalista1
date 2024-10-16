@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Venda de Produtos</h1>



        <div class="bg-white p-6 rounded-lg shadow-md mb-6">


            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($produtos as $produto)
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img class="h-auto max-w-full" src="{{ asset('storage/' . $produto->imagem) }}"
                            alt="{{ $produto->nome }}">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $produto->nome }}</h3>
                            <h3 class="text-lg font-semibold">R${{ $produto->preco_venda }}</h3>
                            <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded"
                                onclick="openAddToCartModal('{{ $produto->id }}', '{{ $produto->nome }}', {{ $produto->preco_venda }})">
                                Adicionar ao Carrinho
                            </button>

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
                    <input type="text" id="coupon_code" name="coupon_code" placeholder="Insira o cupom"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="button" onclick="applyDiscount()"
                        class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:bg-blue-700">Aplicar</button>
                </div>
                <p id="discountMessage" class="mt-2 text-green-600"></p>
                <h3 class="mt-4 text-lg font-semibold">Cupons Disponíveis:</h3>
                <ul class="mt-2">
                    @foreach ($cupons as $cupom)
                        <li class="text-gray-800">- {{ $cupom->codigo }}: {{ $cupom->descricao }} (Desconto:
                            {{ $cupom->desconto_percentual }}%)</li>
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
                <button type="submit" form="saleForm" id="openModal"
                    class="w-full py-3 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 focus:outline-none focus:bg-green-700">Finalizar
                    Venda</button>
            </div>

        </div>
        <x-sucess-modal />
        <x-carrinho-modal :produtos="$produtos" />

        <x-cliente-modal />

    </div>



    <script>
        let cart = [];

        document.addEventListener('DOMContentLoaded', function() {
            const openModalBtn = document.getElementById('openModal');
            const clientemodal = document.getElementById('clientemodal');
            const closeModalBtn = document.getElementById('closeModalBtn');

            openModalBtn.addEventListener('click', () => {
                clientemodal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                clientemodal.classList.add('hidden');
            });

            document.getElementById('customerForm').addEventListener('submit', function(event) {
                const cpf = document.getElementById('cpf').value;
                const nome = document.getElementById('nome').value;
                const telefone = document.getElementById('telefone').value;
                const email = document.getElementById('email').value;


                const produtosInput = document.getElementById('produtosInput');
                produtosInput.value = JSON.stringify(cart);

                const cpfRegex = /^\d{11}$/;
                if (!cpfRegex.test(cpf)) {
                    alert('Por favor, insira um CPF válido com 11 dígitos.');
                    event.preventDefault();
                    return;
                }


                const telefoneRegex = /^\d{10,15}$/;
                if (!telefoneRegex.test(telefone)) {
                    alert('Por favor, insira um telefone válido (10 a 15 dígitos).');
                    event.preventDefault();
                    return;
                }


                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Por favor, insira um e-mail válido.');
                    event.preventDefault();
                    return;
                }
            });
        });


        function openAddToCartModal(productId, productName, productPrice) {
            document.getElementById('modalProductName').innerText = productName;
            const productSelect = document.getElementById('product');
            const quantityInput = document.getElementById('quantidade');
            productSelect.value = productId;
            quantityInput.value = 1;

            document.getElementById('addToCartModal').classList.remove('hidden');
        }

        function closeAddToCartModal() {
            document.getElementById('addToCartModal').classList.add('hidden');
        }

        function addToCart() {
            const productSelect = document.getElementById('product');
            const quantityInput = document.getElementById('quantidade');

            const productId = productSelect.value;
            const productName = productSelect.options[productSelect.selectedIndex].text;
            const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price);
            const quantity = parseInt(quantityInput.value);

            if (productId && quantity > 0) {
                const subtotal = productPrice * quantity;
                cart.push({
                    id: productId,
                    quantidade: quantity,
                    price: productPrice,
                    name: productName,
                    subtotal: subtotal
                });

                renderCart();
                updateTotals();
                closeAddToCartModal();
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
            const discount = parseFloat(document.getElementById('discountAmount').innerText.replace('R$ ', '').replace(',',
                '.')) || 0;
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
                    discount = {{ $cupom->desconto_percentual / 10 }};
                }
            @endforeach

            if (discount > 0) {
                const discountAmount = (subtotal * (discount / 100)).toFixed(2);
                document.getElementById('discountAmount').innerText = `R$ ${discountAmount.replace('.', ',')}`;
                discountMessage.innerText = `Desconto aplicado com sucesso!`;
                updateTotals();
            } else {
                discountMessage.innerText = `Cupom inválido.`;
            }
        }
    </script>
@endsection

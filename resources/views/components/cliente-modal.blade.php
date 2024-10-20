<div id="clientemodal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3 relative">
        <h2 class="text-xl font-semibold mb-4 text-center">Dados do Cliente</h2>
        <form id="customerForm" action="{{ route('venda.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nome" class="block text-gray-700">Nome</label>
                <input type="text" id="nome" name="nome"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required aria-required="true" aria-label="Nome do cliente">
            </div>
            <div class="mb-4">
                <label for="cpf" class="block text-gray-700">CPF</label>
                <input type="text" id="cpf" name="cpf"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required aria-required="true" aria-label="CPF do cliente">
            </div>
            <div class="mb-4">
                <label for="telefone" class="block text-gray-700">Telefone</label>
                <input type="text" id="telefone" name="telefone"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required aria-required="true" aria-label="Telefone do cliente">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">E-mail</label>
                <input type="email" id="email" name="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required aria-required="true" aria-label="E-mail do cliente">
            </div>

            <input type="hidden" id="produtosInput" name="produtos" />
            <input type="hidden" id="desconto" name="desconto" />

            <div class="flex justify-end">
                <button type="button" id="closeModalBtn"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2 transition duration-150 ease-in-out hover:bg-gray-400">Cancelar</button>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md transition duration-150 ease-in-out hover:bg-blue-600">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('clientemodal').classList.add('hidden');
    });
</script>

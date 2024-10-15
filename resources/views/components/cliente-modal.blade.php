<div id="clientemodal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
        <h2 class="text-xl font-semibold mb-4">Dados do Cliente</h2>
        <form id="customerForm">
            <div class="mb-4">
                <label for="customerName" class="block text-gray-700">Nome</label>
                <input type="text" id="customerName" name="customerName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="customerCPF" class="block text-gray-700">CPF</label>
                <input type="text" id="customerCPF" name="customerCPF" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="customerPhone" class="block text-gray-700">Telefone</label>
                <input type="text" id="customerPhone" name="customerPhone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="customerEmail" class="block text-gray-700">E-mail</label>
                <input type="email" id="customerEmail" name="customerEmail" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModalBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md mr-2">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Salvar</button>
            </div>
        </form>
    </div>
    <div class="absolute inset-0 bg-black opacity-50"></div>
</div>

<script>
    const closeModalBtn = document.getElementById('closeModalBtn');
    const clientemodal = document.getElementById('clientemodal');


    closeModalBtn.addEventListener('click', () => {
        cliente.classList.add('hidden');
    });


    document.getElementById('customerForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const customerData = {
            name: document.getElementById('customerName').value,
            cpf: document.getElementById('customerCPF').value,
            phone: document.getElementById('customerPhone').value,
            email: document.getElementById('customerEmail').value,
        };

        fetch('/api/venda', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(customerData)
        }).then(response => {
            if (response.ok) {
                alert('Venda realizada com sucesso!');
                cliente.classList.add('hidden');
            } else {
                alert('Erro ao realizar a venda');
            }
        }).catch(error => {
            console.error('Erro:', error);
        });
    });
</script>

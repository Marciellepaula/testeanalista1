@if ($errors->any())
    <div id="error-modal" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen text-center">
            <div class="bg-gray-500 bg-opacity-75 fixed inset-0"></div>
            <span class="hidden sm:inline-block sm:h-screen">​</span>
            <div class="inline-block bg-white rounded-lg p-4 shadow-xl sm:max-w-lg sm:w-full">
                <h3 class="text-lg font-medium text-gray-900">Erro!</h3>
                <p class="mt-2">{{ $errors->first('error') }}</p>
                <div class="mt-4">
                    <button class="bg-red-600 text-white px-4 py-2 rounded"
                        onclick="document.getElementById('error-modal').style.display='none';">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('error-modal').style.display = 'none';
        }, 3000);
    </script>
@endif

@if (session('success'))
    <div id="success-alert"
        class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg"
        role="alert">
        <strong class="font-bold">Successo!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alertElement = document.getElementById('success-alert');
                if (alertElement) {
                    alertElement.style.display = 'none';
                }
            }, 4000);
        });
    </script>
@endif

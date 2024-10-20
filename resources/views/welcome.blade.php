<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <img src="{{ asset('images/logo.png') }}" alt="Loja Logo"
                    class="mb-8 mx-auto w-32 h-auto object-contain">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <h1 class="text-3xl font-bold text-center lg:col-span-3">Bem-vindo à Loja</h1>

                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end" role="navigation" aria-label="Main Navigation">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition
                                   hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]
                                   dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition
                                   hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]
                                   dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Logar
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition
                                       hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]
                                       dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Registrar
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    © 2024 Loja - Todos os direitos reservados.
                </footer>
            </div>
        </div>
    </div>
</body>

</html>

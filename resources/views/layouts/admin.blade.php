<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Rubik:wght@300..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @stack('styles')
</head>

<body x-data x-cloak>
    <div class="flex flex-col md:flex-row md:h-screen">
        <x-sidebar />

        <main class="flex-1 overflow-y-scroll">
            <div class="w-content">
                <x-profile />

                <x-status status="{{ session('success') }}" class="text-accent" />
                <x-status status="{{ session('error') }}" class="text-red-600" />

                <div class="p-8 my-12 space-y-8 bg-white frame rounded-xl">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    <x-modal name="delete-modal" />

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>

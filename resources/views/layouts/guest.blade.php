<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Rubik:wght@300..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data x-cloak>
    <div class="flex flex-col items-center justify-center min-h-screen gap-6">
        <a href="/" class="block">
            <x-logo variant="color" size="lg" />
        </a>

        <x-status status="{{ session('status') }}" class="text-accent" />
        <x-status status="{{ session('error') }}" class="text-red-600" />

        <div class="w-full max-w-lg p-8 bg-white frame rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>

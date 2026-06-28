<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Museum Expo') }} - Authentication</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite compilation -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo / Brand Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold tracking-wider text-slate-800">
                MUSEUM<span class="text-blue-600">EXPO</span>
            </h1>
            <p class="text-sm text-slate-400 mt-2 font-medium">Sistem Manajemen Pameran Eksternal</p>
        </div>

        <!-- Main Card Wrapper -->
        <div class="bg-white border border-slate-100 rounded-3xl shadow-lg p-8 hover:shadow-xl transition-all duration-300">
            {{ $slot }}
        </div>
    </div>
</body>
</html>

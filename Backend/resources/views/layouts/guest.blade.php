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
<body class="text-slate-900 antialiased min-h-screen flex flex-col items-center justify-center p-4"
      style="background-image: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.7)), url('{{ asset('images/museum_bg.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="w-full max-w-md">
        <!-- Main Card Wrapper -->
        <div class="bg-white border border-slate-100 rounded-3xl shadow-2xl p-8 hover:shadow-slate-900/30 transition-all duration-300">
            <!-- Logo / Brand Header Inside Card -->
            <div class="text-center mb-6 border-b border-slate-100 pb-6">
                <h1 class="text-3xl font-extrabold tracking-wider text-slate-800">
                    MUSEUM<span class="text-blue-600">EXPO</span>
                </h1>
                <p class="text-xs text-slate-400 mt-2 font-semibold">Sistem Manajemen Pameran Eksternal</p>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>
</html>

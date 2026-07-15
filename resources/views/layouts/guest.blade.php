<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased m-0 p-0">
    
    <div class="grid grid-cols-1 md:grid-cols-5 min-h-screen w-full">
        
        <div class="hidden md:flex md:col-span-3 bg-black flex-col items-center justify-center p-12 relative">
            <div class="absolute top-10 left-10 text-gray-700 text-3xl select-none">+</div>
            <div class="absolute bottom-10 right-10 w-6 h-6 border-2 border-gray-700 rounded-full select-none"></div>
            
            <div class="w-full text-center">
                {{ $slot->left_content ?? '' }}
            </div>
        </div>

        <div class="col-span-1 md:col-span-2 bg-gray-50 flex items-center justify-center p-8 sm:p-12 lg:p-16">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                {{ $slot }}
            </div>
        </div>

    </div>

</body>
</html>
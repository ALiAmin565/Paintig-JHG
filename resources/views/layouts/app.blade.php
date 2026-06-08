<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Painting JHG</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    @include('partials.header')

    <main class="flex-1 pt-16 sm:pt-20 md:pt-24 pb-6 sm:pb-8">
        <div class="@yield('content_wrapper_class', 'max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8')">
            @yield('content')
        </div>
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Print') - Painting JHG</title>
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="print-body">
    <div class="print-toolbar">
        <button type="button" class="print-toolbar__btn print-toolbar__btn--primary" onclick="window.print()">Print / Save as PDF</button>
        <button type="button" class="print-toolbar__btn" onclick="window.close()">Close</button>
    </div>

    <main class="print-main">
        @yield('content')
    </main>

    @stack('scripts')
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.print();
            }, 400);
        });
    </script>
</body>
</html>

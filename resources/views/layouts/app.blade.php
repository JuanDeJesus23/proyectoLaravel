<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mi Aplicación')</title>

    <!-- Estilos CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <!-- Otros estilos -->
    @yield('styles')
</head>
<body>
    <div id="app">
        <!-- Cabecera -->
        <header>
            @include('partials.header')
        </header>

        <!-- Contenido principal -->
        <main>
            @yield('content')
        </main>

        <!-- Pie de página -->
        <footer>
            @include('partials.footer')
        </footer>
    </div>

    <!-- Scripts JS -->
    <script src="{{ mix('js/app.js') }}"></script>
    
    <!-- Otros scripts -->
    @yield('scripts')
</body>
</html>

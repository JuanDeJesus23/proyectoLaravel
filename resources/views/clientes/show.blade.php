<!-- resources/views/clientes/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Cliente: {{ $cliente->nombre }}</title>
    <!-- Agregar estilos como en tu ejemplo anterior -->
</head>
<body>
    <div class="container">
        <h1>INFORMACIÓN DEL CLIENTE</h1>
        <div class="info">
            <strong>Nombre:</strong> {{ $cliente->nombre }}<br/>
            <strong>Teléfono:</strong> {{ $cliente->telefono }}<br/>
            <strong>Correo:</strong> {{ $cliente->correo }}<br/>
        </div>
        <div class="image-container">
            <img src="{{ $cliente->imagen_url }}?{{ time() }}" alt="Imagen del Cliente" style="max-width: 600px; border-radius: 5px;">
        </div>
        <!-- Mostrar miniaturas -->
        <h2>Miniaturas</h2>
        <div class="miniaturas">
            <img src="{{ Storage::url("public/{$cliente->id}_miniatura_100x100.jpg") }}?{{ time() }}" alt="Miniatura 100x100">
            <img src="{{ Storage::url("public/{$cliente->id}_miniatura_300x200.jpg") }}?{{ time() }}" alt="Miniatura 300x200">
            <img src="{{ Storage::url("public/{$cliente->id}_miniatura_400x400.jpg") }}?{{ time() }}" alt="Miniatura 400x400">
        </div>
        @if(session('error'))
            <div class="alert alert-danger">
            {{ session('error') }}
            </div>
        @endif

    </div>
</body>
</html>

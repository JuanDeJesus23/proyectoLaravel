<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente: {{ $cliente->nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }
        .form-group label {
            font-weight: bold;
            display: block;
        }
        .form-group input[type="text"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .miniaturas {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .miniaturas img {
            border: 2px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
            object-fit: cover;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Información del Cliente</h1>

        <form action="{{ route('clientes.update', ['cliente' => $cliente->id, 'idsello' => $idsello]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Campos de información del cliente -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
            </div>
        
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="{{ $cliente->telefono }}" required>
            </div>
        
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" value="{{ $cliente->correo }}" required>
            </div>
        
            <!-- Imagen actual y miniaturas -->
            <div class="image-container">
                <h2>Imagen Actual</h2>
                <img src="{{ $cliente->imagen_url }}?{{ time() }}" alt="Imagen del Cliente" style="max-width: 600px; border-radius: 5px;">
            </div>
        
            <h2>Miniaturas</h2>
            <div class="miniaturas">
                <div>
                    <img src="{{ Storage::url("public/{$cliente->id}_miniatura_100x100.jpg") }}?{{ time() }}" 
                         alt="Miniatura 100x100" width="100" height="100">
                </div>
                <div>
                    <img src="{{ Storage::url("public/{$cliente->id}_miniatura_300x200.jpg") }}?{{ time() }}" 
                         alt="Miniatura 300x200" width="300" height="200">
                </div>
                <div>
                    <img src="{{ Storage::url("public/{$cliente->id}_miniatura_400x400.jpg") }}?{{ time() }}" 
                         alt="Miniatura 400x400" width="400" height="400">
                </div>
            </div>
        
            <!-- Campo para cargar nueva imagen -->
            <div class="form-group">
                <label for="imagen">Actualizar Imagen:</label>
                <input type="file" id="imagen" name="imagen">
            </div>
        
            <!-- Botón para actualizar -->
            <button type="submit">Actualizar Cliente</button>
        </form>
        
        
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
    </div>
</body>
</html>

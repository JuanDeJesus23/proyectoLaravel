<!DOCTYPE html>
<html>
<head>
    <title>Cliente: {{ $cliente->nombre }}</title>
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
        .info {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fafafa;
            font-size: 20px;
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
        input[type="file"] {
            margin-bottom: 10px;
        }
        button {
            padding: 20px 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
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
        <h1>IINFORMACIÓN DEL CLIENTE - MOSTRAR CLIENTE</h1>
        <div class="info">
            <strong>Nombre:</strong> {{ $cliente->nombre }}<br/><br/>
            <strong>Teléfono:</strong> {{ $cliente->telefono }}<br/><br/>
            <strong>Correo:</strong> {{ $cliente->correo }}<br/><br/>
        </div>

        <div class="image-container">
            
            <img src="{{ $cliente->imagen_url }}?{{ time() }}" alt="Imagen del Cliente" style="max-width: 600px; border-radius: 5px;">
        </div>

        <!-- Mostrar miniaturas -->
        <h2>Miniaturas</h2>
        <div class="miniaturas">
            <div>
                <img src="{{ Storage::url("public/{$cliente->id}_miniatura_100x100.jpg") }}?{{ time() }}" 
                     alt="Miniatura 100x100" 
                     width="100" height="100">
            </div>
            <div>
                <img src="{{ Storage::url("public/{$cliente->id}_miniatura_300x200.jpg") }}?{{ time() }}" 
                     alt="Miniatura 300x200" 
                     width="300" height="200">
            </div>
            <div>
                <img src="{{ Storage::url("public/{$cliente->id}_miniatura_400x400.jpg") }}?{{ time() }}" 
                     alt="Miniatura 400x400" 
                     width="400" height="400">
            </div>
        </div>

        <form action="{{ route('clientes.subirImagen', $cliente->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="imagen" required>
            <button type="submit">Subir Imagen</button>
        </form>
        
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
    </div>
</body>
</html>

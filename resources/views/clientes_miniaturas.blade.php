<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes con Miniaturas</title>
    <style>
        /* Estilos básicos */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #e0e7ff;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1500px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        h2 {
            color: #4a5568;
            font-size: 1.8em;
            margin-bottom: 20px;
            text-align: center;
        }

        .cliente {
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .cliente:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .miniaturas {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            justify-content: center;
        }

        /* Tamaños específicos para cada miniatura */
        .miniatura-100x100 {
            width: 100px;
            height: 100px;
        }
        
        .miniatura-300x200 {
            width: 300px;
            height: 200px;
        }
        
        .miniatura-400x400 {
            width: 400px;
            height: 400px;
        }

        .miniaturas img {
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .miniaturas img:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            border-color: #6366f1;
        }

        .cliente strong {
            display: block;
            color: #2d3748;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        /* Adaptación para pantallas pequeñas */
        @media (max-width: 600px) {
            .miniaturas {
                flex-direction: column;
                align-items: center;
            }

            .miniatura-100x100 {
                width: 80px;
                height: 80px;
            }

            .miniatura-300x200 {
                width: 240px;
                height: 160px;
            }

            .miniatura-400x400 {
                width: 300px;
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>CLIENTES Y MINIATURAS</h2>
        @foreach ($clientes as $cliente)
            <div class="cliente">
                <strong>Nombre:</strong> {{ $cliente->nombre }}
                <div class="miniaturas">
                    <a href="{{ Storage::url("public/{$cliente->id}_miniatura_100x100.jpg") }}" target="_blank">
                        <img src="{{ Storage::url("public/{$cliente->id}_miniatura_100x100.jpg") }}" alt="Miniatura 100x100" class="miniatura-100x100">
                    </a>
                    <a href="{{ Storage::url("public/{$cliente->id}_miniatura_300x200.jpg") }}" target="_blank">
                        <img src="{{ Storage::url("public/{$cliente->id}_miniatura_300x200.jpg") }}" alt="Miniatura 300x200" class="miniatura-300x200">
                    </a>
                    <a href="{{ Storage::url("public/{$cliente->id}_miniatura_400x400.jpg") }}" target="_blank">
                        <img src="{{ Storage::url("public/{$cliente->id}_miniatura_400x400.jpg") }}" alt="Miniatura 400x400" class="miniatura-400x400">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>

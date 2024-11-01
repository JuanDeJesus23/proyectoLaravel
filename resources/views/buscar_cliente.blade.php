<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE CLIENTES</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #000000;
            color: #343a40;
            margin: 0;
            padding: 20px;
            background-image: url('{{ asset('img/hd-technology.jpg') }}'); /* Ruta a la imagen */
            background-size: cover; /* Cubre toda la pantalla */
            background-position: center; /* Centrar la imagen */
            background-repeat: repeat; /* No repetir la imagen */
            height: 100vh; /* Ocupa toda la pantalla */
            margin: 0; /* Sin margen */
            position: relative; /* Para posicionar la tira de colores */
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
            font-size:50px;

        }
        .client-list {
            display: grid; /* Cambia flex por grid para un mejor control de diseño */
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Define columnas con un ancho mínimo */
            gap: 20px; /* Espacio entre tarjetas */
        }
        .client-card {
            display: flex;
            flex-direction: column; /* Cambia la dirección a columna */
            align-items: center; /* Centra los elementos */
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 300px; /* Establece una altura fija para todas las tarjetas */
        }
        .client-card:hover {
            transform: scale(1.02);
        }
        .client-image {
            width: 100px; /* Ancho de la imagen */
            border-radius: 10px; /* Cambia a esquinas redondeadas */
            object-fit: cover;
            margin-bottom: 10px; /* Espacio entre imagen y texto */
        }
        .client-info {
            flex-grow: 1;
        }
        .client-info h2 {
            margin: 0;
            font-size: 22px;
            color: #343a40;
        }
        .client-info p {
            margin: 5px 0;
            color: #495057;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        button {
        width: 100%; /* Hacer que los botones ocupen todo el ancho de la tarjeta */
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        color: white;
        transition: all 0.3s;
    }

    .alert {
    padding: 15px;
    position: relative;
    margin-bottom: 15px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra */
    color: white;
    }

    /* Alerta de éxito */
    .alert-success {
        background-color: #4CAF50; /* Verde brillante */
        border-left: 8px solid #2e7d32; /* Borde decorativo */
    }

    .alert-success .close {
        color: #d7ffd9; /* Color de botón de cerrar */
    }

    /* Alerta de error */
    .alert-danger {
        background-color: #f44336; /* Rojo brillante */
        border-left: 8px solid #b71c1c; /* Borde decorativo */
    }

    .alert-danger .close {
        color: #ffdadc; /* Color de botón de cerrar */
    }

    /* Botón de cerrar */
    .alert .close {
        position: absolute;
        right: 10px;
        top: 5px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        background: none;
        border: none;
    }

    .alert .close:hover {
        color: #000; /* Cambia de color al pasar sobre él */
    }
        .view-button { background-color: #007bff; }
        .edit-button { background-color: #ffc107; }
        .delete-button { background-color: #dc3545; }
        button:hover { opacity: 0.8; }
    </style>
</head>
<body>
<div class="container">
    
    <!--manejo los mensajes de éxitos y errrores-->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <h1>LISTA DE CLIENTES</h1>
    @if($clientes->isEmpty())
        <p>No hay clientes disponibles.</p>
    @else
        <a href="{{ route('clientes.create') }}">
            <button style="margin-bottom: 20px; background-color: #28a745; font-size: 20px;">Crear Nuevo Cliente</button>
        </a>

        <div class="client-list">
            @foreach ($clientes as $cliente)
                <div class="client-card">
                    <img src="{{ $cliente->imagen_url }}?{{ time() }}" alt="Imagen del Cliente" class="client-image">
                    <div class="client-info">
                        <h2>{{ $cliente->nombre }}</h2>
                        <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                        <p><strong>Correo:</strong> {{ $cliente->correo }}</p>
                    </div>
        
                    <div class="action-buttons">
                        <a href="{{ route('clientes.mostrar', ['id' => $cliente->id, 'idsello' => $hashes[$cliente->id]]) }}">
                            <button class="view-button">Ver Información</button>
                        </a>
                        <a href="{{ route('clientes.edit', ['id' => $cliente->id, 'idsello' => $hashes[$cliente->id]]) }}">
                            <button class="edit-button">Editar</button>
                        </a>                        
                        <form action="{{ route('clientes.destroy', ['id' => $cliente->id]) }}?idsello={{ $hashes[$cliente->id] }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Eliminar</button>
                        </form>
                        
                    </div>
                    
                </div>
            @endforeach
        </div>
        
    </div>
@endif

<script>
    // Selecciona todas las alertas
    const alerts = document.querySelectorAll('.alert');

    // Configura un temporizador para que desaparezcan después de 5 segundos
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0'; // Inicia la animación de desvanecimiento
            setTimeout(() => {
                alert.style.display = 'none'; // Oculta completamente después del desvanecimiento
            }, 500); // Tiempo para la animación (coincide con la transición CSS)
        }, 5000); // Espera 5 segundos antes de iniciar el desvanecimiento
    });
</script>
</body>
</html>

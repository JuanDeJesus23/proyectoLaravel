<!-- resources/views/crear_cliente.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cliente</title>
    <style>
        /* CSS incluido aquí */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
        .botoncito {
            background-color: #57e0ef;
            color: rgb(7, 7, 7);
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
            margin-top: 60px;
            transition: background-color 0.3s;
        }

        .botoncito:hover {
            background-color: #4136dd;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #dff0d8;
            color: #3c763d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Cliente</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('guardarCliente') }}" method="POST">
            @csrf <!-- Token de seguridad -->
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" required>
            </div>
            <div>
                <label for="correo">Correo:</label>
                <input type="email" name="correo" id="correo" required> <!-- Cambiado aquí -->
            </div>
            <div>
                <button type="submit">Crear Cliente</button>
            </div>
        </form>
        <button type="button" class="botoncito" onclick="window.location.href='/bienvenido'">Ir a la zona protegida</button>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Buscar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f2f2ce;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px; /* Aumenta el ancho */
            height: 400px; /* Aumenta la altura */
            margin: 20px auto; /* Centra horizontalmente y da espacio arriba */
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            position: relative;
        }
        h1 {
            color: #333;
            font-size: 2em;
        }
        input[type="text"] {
            width: 100%;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 18px;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #4287fd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #031cfb;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-top: 15px;
        }
        /* Barra de colores */
        .color-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(90deg, blue, red, yellow, orange, red);
            background-size: 500%;
            animation: colorShift 5s infinite linear;
            border-radius: 0 0 10px 10px;
        }
        @keyframes colorShift {
            0% { background-position: 0%; }
            100% { background-position: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Buscar Cliente</h1>
        <form action="{{ route('clientes.buscarCliente') }}" method="POST">
            @csrf
            <input type="text" name="id" placeholder="Ingrese ID del cliente" required>
            <button type="submit">Buscar</button>
        </form>
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <div class="color-bar"></div> <!-- Barra de colores animada -->
    </div>
</body>
</html>

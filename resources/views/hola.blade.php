<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola Mundo</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
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
        .container {
            text-align: center;
            background: white;
            padding: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #333;
            font-size: 48px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola Mundo!</h1>
        <p>Este es tu primer mensaje en Laravel.</p>
        <button type="button" class="botoncito" onclick="window.location.href='/bienvenido'">Ir a la zona protegida</button>
    </div>
    
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('/img/dragon-ball-z.jpg'); /* Ruta a la imagen */
            background-size: cover; /* Cubre toda la pantalla */
            background-position: center; /* Centrar la imagen */
            background-repeat: no-repeat; /* No repetir la imagen */
            height: 100vh; /* Ocupa toda la pantalla */
            margin: 0; /* Sin margen */
            position: relative; /* Para posicionar la tira de colores */
        }

        /* Tira de colores en el lado izquierdo */
        .color-strip {
            position: absolute;
            left: 2rem;
            top: 0;
            width: 100px; /* Ancho de la tira */
            height: 100%; /* Ocupa toda la altura */
            background: linear-gradient(0deg, #ff9999, #ffcc99, #99ff99, #99ccff); /* Gradiente de colores */
            background-size: 100% 200%; /* Aumenta el tamaño del gradiente */
            animation: slideColors 5s linear infinite; /* Animación */
        }

        /* Animación que simula los colores subiendo */
        @keyframes slideColors {
            0% {
                background-position: 0 100%; /* Empieza desde abajo */
            }
            100% {
                background-position: 0 0%; /* Termina arriba */
            }
        }

        .login-container {
            background-color: #fff;
            padding: 5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            animation: changeColor 5s infinite; /* Aplicamos la animación */
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .error-list {
            color: red;
            margin-bottom: 1rem;
            padding: 0;
            list-style-type: none;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 0.5rem;
            background-color: #5cb85c;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4cae4c;
        }

        @keyframes changeColor {
            0% { background-color: #ff9999; } /* Color inicial */
            25% { background-color: #ffcc99; } /* Segundo color */
            50% { background-color: #99ff99; } /* Tercer color */
            75% { background-color: #99ccff; } /* Cuarto color */
            100% { background-color: #ff9999; } /* Volver al color inicial */
        }

        @media (max-width: 400px) {
            .login-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Tira de colores en el lado izquierdo -->
    <div class="color-strip"></div>

    <div class="login-container">
        <h1>Iniciar sesión</h1>

        @if ($errors->any())
            <div>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>

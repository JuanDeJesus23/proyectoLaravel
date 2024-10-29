<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
            background-image: url('/img/Colorful-Mountain.jpeg'); /* Ruta a la imagen */
            background-size: cover; /* Cubre toda la pantalla */
            background-position: center; /* Centrar la imagen */
            background-repeat: no-repeat; /* No repetir la imagen */
            height: 100vh; /* Ocupa toda la pantalla */
            margin: 0; /* Sin margen */
        }
        .mensaje {
            text-align: center;
            font-size: 48px;
            color: #4CAF50; /* Color verde */
            padding: 20px;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            background-color: #fff; /* Fondo blanco */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .temp{
            position: absolute; /* Posicionar el botón */
            bottom: 20px; /* Espacio desde el fondo */
            left: 20px; /* Espacio desde la izquierda */
            background-color: #007bff; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px 20px; /* Espaciado interno */
            font-size: 1.2em; /* Tamaño de fuente */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
            transition: background-color 0.3s; /* Efecto de transición */
        }
        .temp:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
        }
        .temp2{
            position: absolute; /* Posicionar el botón */
            bottom: 20px; /* Espacio desde el fondo */
            left: 520px; /* Espacio desde la izquierda */
            background-color: #007bff; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px 20px; /* Espaciado interno */
            font-size: 1.2em; /* Tamaño de fuente */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
            transition: background-color 0.3s; /* Efecto de transición */

        }
        .temp2:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
        }
        .temp3{
            position: absolute; /* Posicionar el botón */
            bottom: 500px; /* Espacio desde el fondo */
            left: 520px; /* Espacio desde la izquierda */
            background-color: #51fc22; /* Color de fondo del botón */
            color: rgb(9, 9, 9); /* Color del texto del botón */
            border: none; /* Sin borde */
            border-radius: 5px; /* Bordes redondeados */
            padding: 10px 20px; /* Espaciado interno */
            font-size: 1.2em; /* Tamaño de fuente */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
            transition: background-color 0.3s; /* Efecto de transición */

        }
        .temp3:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
        }
        .btn-logout {
        background-color: #d9534f;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1.2em;
        border-radius: 5px;
        cursor: pointer;
        position: absolute; /* Posicionar el botón */
        bottom: 20px; /* Espacio desde el fondo */
        left: 1020px; /* Espacio desde la izquierda */
    }

    .btn-logout:hover {
        background-color: #c9302c;
    }
    </style>
</head>
<body>
    <div class="mensaje">
        BIENVENIDO A LA ZONA PROTEGIDA
    </div>

    <button type="button" class="btn btn-primary temp" onclick="window.location.href='/hola'">Ir a HOLA MUNDO</button>
    <button type="button" class="btn btn-primary temp2" onclick="window.location.href='/clientes'">Ir a CLIENTES</button>
    <button type="button" class="btn btn-primary temp3" onclick="window.location.href='/formCliente'">Crear nuevo cliente</button>
    <!--BOTON PARA CERRAR LA SESION-->
    <nav>
        <!-- Otros enlaces de navegación -->
        <button class="btn btn-danger btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
        </button>
    </nav>
    
    <!-- El formulario está oculto -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
</body>
</html>

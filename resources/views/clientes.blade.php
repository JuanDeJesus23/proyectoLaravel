<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif; /* Fuente general */
            background-color: #f4f4f4; /* Color de fondo */
            margin: 0;
            padding: 20px;
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
    
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0; /* Espacio alrededor de la tabla */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra para dar profundidad */
            border-radius: 8px; /* Bordes redondeados */
            overflow: hidden; /* Esconde bordes redondeados */
        }
    
        th, td {
            padding: 15px; /* Espaciado dentro de las celdas */
            text-align: center;
        }
    
        th {
            background-color: #4CAF50; /* Color de fondo de los encabezados */
            color: white; /* Color del texto de los encabezados */
            font-weight: bold; /* Texto en negrita */
        }
    
        td {
            background-color: #ffffff; /* Color de fondo de las celdas */
            transition: background-color 0.3s; /* Transición suave para el efecto hover */
        }
    
        /* Efecto hover para las celdas */
        tr:hover td {
            background-color: #f1f1f1; /* Color al pasar el ratón sobre las celdas */
        }
    
        /* Estilo de la primera columna */
        tr td:first-child {
            font-weight: bold; /* Texto en negrita */
            color: #333; /* Color del texto */
        }
    
        /* Estilo para filas alternas */
        tr:nth-child(even) td {
            background-color: #f9f9f9; /* Color de fondo para filas pares */
        }
    
        /* Estilo para filas alternas en hover */
        tr:nth-child(even):hover td {
            background-color: #e0e0e0; /* Color de fondo al pasar el ratón sobre filas pares */
        }
    </style>
    
</head>
<body>
    <h1>Lista de Clientes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="button" class="botoncito" onclick="window.location.href='/bienvenido'">Ir a la zona protegida</button>
</body>
</html>

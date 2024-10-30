<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE CLIENTES</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            color: #343a40;
            margin: 0;
            padding: 20px;
            font-size: 18px;
        }
        .container {
            max-width: 1500px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #495057;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        td {
            background-color: #f8f9fa;
        }
        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .edit-button {
            background-color: #ffc107;
            color: white;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
        }
        .create-button {
            background-color: #28a745;
            color: white;
            margin-bottom: 20px;
            width: 250px;
            height: 100px;
            font-size: 20px;
            
        }
        button:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }
        a {
            text-decoration: none;
        }
        .view-button {
            background-color: #007bff;
            color: white;
        }
        .view-button:hover {
            background-color: #0056b3;
        }
        .alert {
            background-color: #f44336; /* Color rojo */
            color: white; /* Texto blanco */
            padding: 15px; /* Espaciado */
            position: relative; /* Para el posicionamiento */
            margin-bottom: 15px; /* Espaciado inferior */
            text-align: center;
            font-size: 25px;
            font-weight: bold; /* Esto hará que el texto sea negrita */
        }

        .alert .close {
            position: absolute;
            right: 10px;
            top: 5px;
            color: white; /* Color del botón cerrar */
            cursor: pointer; /* Cursor de puntero */
        }

    </style>
</head>
<body>
@if($clientes->isEmpty())
    <p>No hay clientes disponibles.</p>
@else
    <!-- Aquí va tu tabla de clientes -->


    <div class="container">
        <!-- Mensaje de error -->
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <h1>LISTA DE CLIENTES</h1>

        <a href="{{ route('clientes.create') }}">
            <button class="create-button">Crear Nuevo Cliente</button>
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->correo }}</td>
                        <td>
                            <!-- Botón para ver detalles del cliente -->
                            <a href="{{ route('clientes.mostrar', ['id' => $cliente->id]) }}?id={{ $hashes[$cliente->id] }}">
                                <button class="view-button">Ver Información</button>
                            </a>
                                                     
                            <!-- Botón para editar cliente -->
                            <a href="{{ route('clientes.edit', $cliente->id) }}">
                                <button class="edit-button">Editar</button>
                            </a>
                            
                            <!-- Formulario para eliminar cliente -->
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>

@extends('layouts.app') <!-- Cambia esto si tu layout se llama diferente -->

@section('content')
<div class="container">
    <h1>Lista de Clientes</h1>
    
    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Crear Nuevo Cliente</a> <!-- Botón para crear nuevo cliente -->
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }}</td> <!-- Asegúrate de que el atributo nombre exista en tu modelo -->
                    <td>
                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">Editar</a> <!-- Botón de editar -->
                        <a href="{{ route('clientes.destroy', $cliente->id) }}" class="btn btn-danger" onclick="event.preventDefault(); if(confirm('¿Estás seguro de que deseas eliminar este cliente?')) { document.getElementById('delete-form-{{ $cliente->id }}').submit(); }">Eliminar</a> <!-- Botón de eliminar -->
                        <form id="delete-form-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

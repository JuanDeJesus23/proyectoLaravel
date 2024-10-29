<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RefreshSessionTTL;

Route::get('/hola', [ClienteController::class, 'mostrarHola']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/clientes', [ClienteController::class, 'listarClientes'])->name('clientes');
//RUTAS PARA LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

//Utilizo el MIDDLEWARE para evitar que usuarios no loggeados accedan a las vistas
Route::middleware(['auth'])->group(function () {

    // Ruta protegida para "hola"
    Route::get('/hola',[ClienteController::class,'mostrarHola']);

    // Ruta protegida para "clientes"
    Route::get('/clientes',[ClienteController::class,'listarClientes']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return 'Bienvenido al área protegida!';
    });
});

//ruta para cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//crear un cliente con contraseña cifrada
Route::get('/bienvenido', [LoginController::class, 'bienvenido']);

//ruta para crear un cliente
Route::get('/crearCliente', [ClienteController::class, 'crearCliente']);


//ruta del middleware
Route::get('/middleware', [RefreshSessionTTL::class, 'handle']);


Route::get('/formCliente', [ClienteController::class, 'mostrarFormulario']);
//ruta para el formulario de crear cliente
Route::post('/guardarCliente', [ClienteController::class, 'guardarCliente']);

// rutas para probar IMAGICK
Route::get('/buscar-cliente', [ClienteController::class, 'mostrarFormulario2'])->name('clientes.buscar');
Route::post('/buscar-cliente', [ClienteController::class, 'buscarCliente'])->name('clientes.buscarCliente');
Route::post('/subir-imagen/{id}', [ClienteController::class, 'subirImagen'])->name('clientes.subirImagen');

//Ruta para la vista quqe muestra clientes con miniaturas
Route::get('/clientes-miniaturas', [ClienteController::class, 'listarClientesConMiniaturas'])->name('clientes.miniaturas');





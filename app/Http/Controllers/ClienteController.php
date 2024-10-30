<?php
namespace App\Http\Controllers;


use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Imagick;

class ClienteController extends Controller
{
    public function mostrarHola()
    {
        return view('hola');
    }

    public function listarClientes()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('clientes', compact('clientes')); // Pasar la variable a la vista
    }


    public function crearCliente()
    {
        $nombre = 'Juan de Jesus Alvarez';
        $email = 'alvarez@gmail.com';
        $password = '1234'; // Contraseña en texto plano

        // Cifrar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el registro en la base de datos
        DB::insert("INSERT INTO usuarios_sistema (nombre, email, password, created_at, updated_at) 
        VALUES (?, ?, ?, NOW(), NOW())", [$nombre, $email, $hashedPassword]);

        return "Cliente creado con éxito!";
    }

    // metodos para mostrar y agregar cliente
    

    public function mostrarFormulario()
    {
        return view('crear_cliente'); // Asegúrate de crear esta vista
    }

    public function guardarCliente(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string',
            'correo' => 'required|string|email|max:255|unique:clientes', // Asegúrate de que el correo sea único
        ]);

        $nombre = $request->input('nombre');
        $telefono = $request->input('telefono');
        $correo = $request->input('correo');

        try {
            // Insertar el registro en la base de datos
            DB::insert("INSERT INTO clientes (nombre, telefono, correo, created_at, updated_at) 
            VALUES (?, ?, ?, NOW(), NOW())", [$nombre, $telefono, $correo]);
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()->withErrors(['error' => 'Error al guardar el cliente: ' . $e->getMessage()]);
        }

        return redirect('/clientes')->with('success', 'Cliente creado con éxito!'); // Redirigir a la lista de clientes
    }

    #METODOS para probar IMAGICK
    //MEtodo para la vista LISTARCLIENTES
    public function mostrarFormulario2()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('buscar_cliente', compact('clientes')); // Pasar la variable a la vista
    }

    public function buscarCliente(Request $request)
    {
        $cliente = Cliente::find($request->id);
        
        if (!$cliente) {
            return back()->withErrors(['id' => 'Cliente no encontrado']);
        }

        return view('mostrar_cliente', compact('cliente'));
    }

    public function subirImagen(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,png' // 3MB
        ]);
        /*Validación de la imagen: Se valida la solicitud para asegurarse de que el campo imagen está presente (required), es una imagen (image), tiene uno de los formatos permitidos (mimes:jpg,png), y no supera los 3 MB (max:3072).*/

        $cliente = Cliente::find($id);

        if ($cliente) {
            // Procesar la imagen solo si es válida
            if ($request->file('imagen')->isValid()) {
                $imagen = new Imagick($request->file('imagen')->getPathname());
            
                // Redimensionar
                if ($imagen->getImageWidth() > 1200) {
                    $imagen->resizeImage(1200, 0, Imagick::FILTER_LANCZOS, 1);
                }
                
                // Almacenar la imagen procesada
                $path = 'public/' . $cliente->id . '_imagen.jpg'; // Define un nombre de archivo
                $imagen->writeImage(storage_path('app/' . $path)); // Guarda la imagen procesada
                
                // Generar miniaturas
                $this->crearMiniatura($imagen, $cliente->id, 100, 100);
                $this->crearMiniatura($imagen, $cliente->id, 300, 200);
                $this->crearMiniatura($imagen, $cliente->id, 400, 400);
                
                $imagen->destroy(); // Destruir la instancia de Imagick
                
                // Obtener la URL de la imagen guardada
                $url = Storage::url($path);
                $cliente->imagen_url = $url;
                $cliente->save();

                return redirect()->route('clientes.buscar')->with('success', 'Imagen subida con éxito');
            }
        }

        return redirect()->back()->with('error', 'Cliente no encontrado o imagen no válida.');
    }

    private function crearMiniatura($imagen, $clienteId, $ancho, $alto)
    {
        // Clonar la imagen original
        $miniatura = clone $imagen;

        // Redimensionar y recortar la imagen para obtener la miniatura
        $miniatura->thumbnailImage($ancho, $alto, true); // true para mantener la proporción
        $miniatura->cropImage($ancho, $alto, 0, 0); // Ajustar el recorte según sea necesario
                                                    //0, 0 coordenadas desde donde comenzaará el recorte
        // Guardar la miniatura
        $pathMiniatura = "public/{$clienteId}_miniatura_{$ancho}x{$alto}.jpg"; // Define un nombre de archivo
        $miniatura->writeImage(storage_path('app/' . $pathMiniatura)); // Guarda la miniatura procesada
        $miniatura->destroy(); // Destruir la instancia de la miniatura
    }

    public function listarClientesConMiniaturas()
    {
        // Obtener todos los clientes con su imagen y miniaturas
        $clientes = Cliente::all();

        return view('clientes_miniaturas', compact('clientes'));
    }

    #- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    #- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    #- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    #- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    #- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
    public function listarClientesConBoton()
            {
                $clientes = Cliente::all(); // Obtener todos los clientes
                return view('clientes_lista', compact('clientes')); // Pasar la variable a la vista
            }
    // Dentro del ClienteController
        public function mostrarFormularioImagen($id)
            {
                $clientes = Cliente::find($id);
                
                if (!$clientes) {
                    return redirect()->back()->withErrors(['id' => 'Cliente no encontrado']);
                }

                return view('subir_imagen', compact('clientes')); // Asegúrate de que este es el nombre correcto de la vista
            }

            // Método para listar todos los clientes
        public function index()
            {
                $clientes = Cliente::all(); // Obtiene todos los clientes
                return view('buscar_cliente', compact('clientes')); // Pasa los clientes a la vista
            }

        // Métodos para editar y eliminar (agrega según sea necesario)
        public function update(Request $request, $id)
            {
                // Validar los datos
                $request->validate([
                    'nombre' => 'required|string|max:255',
                    'telefono' => 'required|string|max:255',
                    'correo' => 'required|email|unique:clientes,correo,' . $id,
                    'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
                ]);

                // Buscar el cliente
                $cliente = Cliente::find($id);
                if (!$cliente) {
                    return redirect()->back()->with('error', 'Cliente no encontrado.');
                }

                // Actualizar datos del cliente
                $cliente->nombre = $request->nombre;
                $cliente->telefono = $request->telefono;
                $cliente->correo = $request->correo;

                // Procesar y actualizar la imagen si se carga una nueva
                if ($request->hasFile('imagen')) {
                    $imagen = new Imagick($request->file('imagen')->getPathname());

                    // Redimensionar si es necesario
                    if ($imagen->getImageWidth() > 1200) {
                        $imagen->resizeImage(1200, 0, Imagick::FILTER_LANCZOS, 1);
                    }

                    // Guardar la imagen
                    $path = 'public/' . $cliente->id . '_imagen.jpg';
                    $imagen->writeImage(storage_path('app/' . $path));
                    $cliente->imagen_url = Storage::url($path);

                    // Generar miniaturas
                    $this->crearMiniatura($imagen, $cliente->id, 100, 100);
                    $this->crearMiniatura($imagen, $cliente->id, 300, 200);
                    $this->crearMiniatura($imagen, $cliente->id, 400, 400);
                    $imagen->destroy();
                }

                // Guardar los cambios
                $cliente->save();

                return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito');
            }
        
        public function create()
            {
                return view('create');
            }
            
        public function store(Request $request)
            {
                $request->validate([
                    'nombre' => 'required|string|max:255',
                    'telefono' => 'required|string|max:255',
                    'correo' => 'required|email|unique:clientes,correo',
                    'imagen_url' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
                ]);
            
                // Inicializar imagen_url en NULL por defecto
                $filePath = null;
            
                // Subir archivo si se proporciona
                if ($request->hasFile('imagen_url')) {
                    $filePath = $request->file('imagen_url')->store('clientes', 'public');
                }
            
                // Insertar el cliente en la base de datos sin Eloquent
                DB::insert('INSERT INTO clientes (nombre, telefono, correo, imagen_url, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())', [
                    $request->nombre,
                    $request->telefono,
                    $request->correo,
                    $filePath,
                ]);
            
                return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
            }  
            
        public function formUpdate($id)
            {
                $cliente = Cliente::find($id);
            
                if (!$cliente) {
                    return redirect()->back()->with('error', 'Cliente no encontrado.');
                }
            
                return view('edit', compact('cliente'));
            }
            
            //metodo para el boton VER DETALLES
        public function mostrarCliente($id)
            {
                $cliente = Cliente::find($id);

                if (!$cliente) {
                    return redirect()->back()->with('error', 'Cliente no encontrado.');
                }

                return view('mostrar_cliente', compact('cliente')); // Asegúrate de que la vista existe
            }

        public function destroy($id)
            {
                    // Buscar el cliente
                    $cliente = Cliente::find($id);
                
                    // Verificar si el cliente existe
                    if (!$cliente) {
                        return redirect()->back()->with('error', 'Cliente no encontrado.');
                    }
                
                    // Eliminar el cliente
                    $cliente->delete();
                
                    return redirect()->route('clientes.index');
            }


}   
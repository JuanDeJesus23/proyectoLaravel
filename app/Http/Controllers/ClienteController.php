<?php
namespace App\Http\Controllers;


use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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

    public function buscarCliente(Request $request)
    {
        $cliente = Cliente::find($request->id);
        
        if (!$cliente) {
            return back()->withErrors(['id' => 'Cliente no encontrado']);
        }

        return view('mostrar_cliente', compact('cliente'));
    }
//- - - - - - - - - - - -  --  - -- - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - -  - - - - - -  - - 
    public function subirImagen(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,png|max:3072'
        ]);

        $cliente = Cliente::find($id);

        if ($cliente) {
            // Procesar la imagen solo si es válida
            if ($request->file('imagen')->isValid()) {
                $imagen = new Imagick($request->file('imagen')->getPathname());

                // Obtener el ancho original
                $anchoOriginal = $imagen->getImageWidth();

                // Redimensionar solo si el ancho es mayor a 1200 píxeles
                if ($anchoOriginal > 1200) {
                    $imagen->thumbnailImage(1200, 0); // Ajustar el ancho a 1200 y mantener la proporción
                }

                // Almacenar la imagen procesada
                $path = 'public/' . $cliente->id . '_imagen.jpg';
                $imagen->writeImage(storage_path('app/' . $path));

                // Generar miniaturas
                $this->crearMiniatura($imagen, $cliente->id, 100, 100);
                $this->crearMiniatura($imagen, $cliente->id, 300, 200);
                $this->crearMiniatura($imagen, $cliente->id, 400, 400);

                $imagen->destroy();

                // Guardar la URL de la imagen en la base de datos
                $url = Storage::url($path);
                $cliente->imagen_url = $url;
                $cliente->save();

                return redirect()->route('clientes.manejar')->with('success', 'Imagen subida con éxito');
            }
        }

        return redirect()->back()->with('error', 'Cliente no encontrado o imagen no válida.');
    }


    private function crearMiniatura($imagen, $clienteId, $ancho, $alto)
        {
            // Clonar la imagen original
            $miniatura = clone $imagen;

            // Obtener dimensiones de la imagen original
            $anchoOriginal = $miniatura->getImageWidth();
            $altoOriginal = $miniatura->getImageHeight();

            // Calcular el punto de inicio para el recorte
            // Para mantener el aspecto de la miniatura, recortamos la parte superior e inferior o los lados
            if ($anchoOriginal / $altoOriginal > $ancho / $alto) {
                // La imagen es más ancha que la proporción de la miniatura
                $nuevoAlto = $altoOriginal; // Mantener el alto original
                $nuevoAncho = $altoOriginal * ($ancho / $alto); // Ajustar ancho

                // Calcular el punto de inicio para el recorte centrado
                $x = ($anchoOriginal - $nuevoAncho) / 2;
                $y = 0; // Desde la parte superior

                // Recortar la imagen
                $miniatura->cropImage($nuevoAncho, $nuevoAlto, $x, $y);
            } else {
                // La imagen es más alta que la proporción de la miniatura
                $nuevoAncho = $anchoOriginal; // Mantener el ancho original
                $nuevoAlto = $anchoOriginal * ($alto / $ancho); // Ajustar alto

                // Calcular el punto de inicio para el recorte centrado
                $x = 0; // Desde el lado izquierdo
                $y = ($altoOriginal - $nuevoAlto) / 2;

                // Recortar la imagen
                $miniatura->cropImage($nuevoAncho, $nuevoAlto, $x, $y);
            }

            // Redimensionar la miniatura a las dimensiones deseadas
            $miniatura->thumbnailImage($ancho, $alto, true); // true para mantener la proporción

            // Guardar la miniatura
            $pathMiniatura = "public/{$clienteId}_miniatura_{$ancho}x{$alto}.jpg"; // Define un nombre de archivo
            $miniatura->writeImage(storage_path('app/' . $pathMiniatura)); // Guarda la miniatura procesada
            $miniatura->destroy(); // Destruir la instancia de la miniatura
        }

//- - - - - - - - - - - -  --  - -- - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - -  - - - - - -  - - 

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
            $clientes = Cliente::all();
            $hashes = [];
        
            foreach ($clientes as $cliente) {
                // Genera el hash como lo tienes configurado en tu proyecto
                $hashes[$cliente->id] = substr(hash('sha256', $cliente->id . config('app.url_salt')), -8);
            }
        
            return view('buscar_cliente', compact('clientes', 'hashes'));
        }
            

        // Métodos para editar y eliminar (agrega según sea necesario)
        
        
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

            //MEtodo para la vista LISTARCLIENTES
        
            
            //metodo para el boton VER DETALLES
        public function mostrarCliente($id, Request $request)
            {
                $hash = $request->query('idsello');  // Obtener el hash desde los parámetros de consulta
            
                // Generar el hash esperado
                $hashGenerado = $this->generarHash($id);
            
                // Validar el hash
                if ($hash !== $hashGenerado) {
                    return redirect()->route('clientes.manejar')->with('error', 'ACCESO NO AUTORIZADO DESDE MOSTRAR CLIENTE.');
                }
            
                $cliente = Cliente::findOrFail($id);
                return view('mostrar_cliente', compact('cliente'));
            }
            
#  - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - - 

        public function generarHash($id)
            {
                $salt = env('URL_SALT');
                $hash = hash('sha256', $salt . $id);
                
                // Tomar los 8 primeros caracteres de derecha a izquierda
                return substr(strrev($hash), 0, 8);
            }   

            public function manejarClientes(Request $request, $id = null)
            {
                $hashes = [];
                
                // Obtener el hash de la consulta
                $hash = $request->query('idsello');
            
                // Si se recibe un ID y un hash, intentamos mostrar el cliente específico
                if ($id && $hash) {
                    $hashGenerado = $this->generarHash($id);
            
                    // Validar el hash recibido con el generado
                    if ($hash !== $hashGenerado) {
                        return redirect()->route('clientes.manejar')->with('error', 'ACCESO NO AUTORIZADO.');
                    }
            
                    // Intentar obtener el cliente
                    $cliente = Cliente::find($id);
            
                    // Verificar si el cliente existe
                    if (!$cliente) {
                        return redirect()->route('clientes.manejar')->with('error', 'Cliente no encontrado.');
                    }
            
                    return view('mostrar_cliente', compact('cliente'));
                }
            
                // Si no se recibe ID ni hash, generamos la lista completa de clientes con sus hashes
                $clientes = Cliente::all();
            
                foreach ($clientes as $cliente) {
                    $hashes[$cliente->id] = $this->generarHash($cliente->id);
                }
            
                // Mostrar la vista de lista de clientes
                return view('buscar_cliente', compact('clientes', 'hashes'));
            }
            
            
            
# - - - - - - -  - - - - - - - - - - - - - - - - - - -  -UPDATE
    public function formUpdate($id, Request $request)
    {
        $hash = $request->query('idsello');
        // Generar el hash esperado
        $hashGenerado = $this->generarHash($id);
            
        // Validar el hash
        if ($hash !== $hashGenerado) {
            return redirect()->route('clientes.manejar')->with('error', 'ACCESO NO AUTORIZADO DESDE EDICION.');
        }

        // Buscar el cliente
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->route('clientes.manejar')->with('error', 'Cliente no encontrado.');
        }

        return view('edit', compact('cliente', 'hashGenerado'));
    }
  


    public function update(Request $request, $id)
            {
                // Validar 'idsello'
                $idsello = $request->query('idsello');
                $expectedIdsello = substr(hash('sha256', $id . config('app.url_salt')), -8);

                if ($idsello !== $expectedIdsello) {
                    return redirect()->route('clientes.index')->with('error', 'Acceso no autorizado.');
                }


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
                    return redirect()->route('clientes.index')->with('error', 'Cliente no encontrado.');
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

            


}   
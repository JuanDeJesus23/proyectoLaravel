<?php

namespace Database\Seeders; // Asegúrate de incluir esto

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        Cliente::create([
            'nombre' => 'Juan Pérez',
            'telefono' => '123456789',
            'correo' => 'juan@example.com'
        ]);

        Cliente::create([
            'nombre' => 'María García',
            'telefono' => '987654321',
            'correo' => 'maria@example.com'
        ]);
    }
}

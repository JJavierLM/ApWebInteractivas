<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        // Crear un empleado
        User::create([
            'name'     => 'EmpleadoPrueba',
            'email'    => 'empleado@demo.com',
            'password' => bcrypt('empleado123'),
            'role'     => 'empleado',
        ]);
    }
}

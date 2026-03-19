<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear usuaride prueba 
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('12345'),
            'id_number' => '123456789',
            'phone' => '999999999',
            'address' => '123 Main St, Anytown, USA',

        ]) -> assignRole('Administrador');
    }
}

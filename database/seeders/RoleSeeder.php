<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // definimos los roles de nuestra base de datos
        $roles = [
            'Doctor',
            'Paciente',
            'Recepcionista',
            'Administrador',
            'Super Administrador',
            
        ];

        //recorremos el arreglo de roles para insertarlos en la base de datos
        foreach ($roles as $rol){
            Role::create(['name' => $rol]);
        }
    }
}

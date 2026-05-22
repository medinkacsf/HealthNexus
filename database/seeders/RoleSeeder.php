<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super_Admin'],
            ['name' => 'Director_Medico'],
            ['name' => 'Medico_Nivel_A'],
            ['name' => 'Medico_Nivel_B'],
            ['name' => 'Medico_Nivel_C'],
            ['name' => 'Enfermeria'],
            ['name' => 'Farmacia'],
            ['name' => 'Admision']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
        
        $this->command->info('✅ Roles del hospital creados exitosamente.');
    }
}

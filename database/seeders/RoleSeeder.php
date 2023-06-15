<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Empleado']);

        Permission::create(['name' => 'view-admin'])->assignRole($role1);
        Permission::create(['name' => 'ver-rol'])->assignRole($role1);
        Permission::create(['name' => 'editar-rol'])->assignRole($role1);
        Permission::create(['name' => 'crear-rol'])->assignRole($role1);
        Permission::create(['name' => 'añadir-rol'])->assignRole($role1);
        Permission::create(['name' => 'eliminar-rol'])->assignRole($role1);
        Permission::create(['name' => 'ver-usuario'])->assignRole($role1);
        Permission::create(['name' => 'filtrar-usuario'])->assignRole($role1);
        Permission::create(['name' => 'crear-usuario'])->assignRole($role1);
        Permission::create(['name' => 'eliminar-usuario'])->assignRole($role1);
        Permission::create(['name' => 'editar-usuario'])->assignRole($role2);
        Permission::create(['name' => 'ver-redes'])->assignRole($role2);
        Permission::create(['name' => 'crear-redes'])->assignRole($role2);
        Permission::create(['name' => 'eliminar-redes'])->assignRole($role2);

        $useradmin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'cargo' => 'ADMIN'
        ]);

        $useradmin->assignRole('Admin');

        User::create([
            'name' => 'trabajador',
            'email' => 'trabajador@gmail.com',
            'password' => bcrypt('12345678'),
            'cargo' => 'AUNXILIAR'
        ]);

    }
}

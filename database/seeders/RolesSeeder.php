<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rol base para asignar en el alta de usuario
        Role::firstOrCreate(['name' => 'Recepcionista']);

        $permissions = [
            // Ventas
            ['name' => 'ventas.ver', 'descripcion' => 'Permite ver las ventas'],
            ['name' => 'ventas.crear', 'descripcion' => 'Permite crear una venta'],
            ['name' => 'ventas.editar', 'descripcion' => 'Permite editar una venta'],
            ['name' => 'ventas.eliminar', 'descripcion' => 'Permite eliminar una venta'],
            // Compras
            ['name' => 'compras.ver', 'descripcion' => 'Permite ver las compras'],
            ['name' => 'compras.crear', 'descripcion' => 'Permite crear una compra'],
            ['name' => 'compras.editar', 'descripcion' => 'Permite editar una compra'],
            ['name' => 'compras.eliminar', 'descripcion' => 'Permite eliminar una compra'],
            // Inventario
            ['name' => 'inventario.ver', 'descripcion' => 'Permite ver el inventario'],
            ['name' => 'inventario.crear', 'descripcion' => 'Permite crear un producto en el inventario'],
            ['name' => 'inventario.editar', 'descripcion' => 'Permite editar un producto en el inventario'],
            ['name' => 'inventario.eliminar', 'descripcion' => 'Permite eliminar un producto en el inventario'],
            // Usuarios
            ['name' => 'usuarios.ver', 'descripcion' => 'Permite ver los usuarios'],
            ['name' => 'usuarios.crear', 'descripcion' => 'Permite crear un usuario'],
            ['name' => 'usuarios.editar', 'descripcion' => 'Permite editar un usuario'],
            ['name' => 'usuarios.eliminar', 'descripcion' => 'Permite eliminar un usuario'],
            // Clientes
            ['name' => 'Cliente', 'descripcion' => 'Permite gestionar clientes'],
            ['name' => 'clientes.store', 'descripcion' => 'Permite registrar clientes'],
            ['name' => 'clientes.update', 'descripcion' => 'Permite actualizar clientes'],
            ['name' => 'clientes.borrar', 'descripcion' => 'Permite eliminar clientes'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], ['descripcion' => $permission['descripcion']]);
        }
    }
}

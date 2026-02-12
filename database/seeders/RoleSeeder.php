<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Cliente']);

        Permission::create(['name' => 'admin.list', 'description' => 'ver lista de reportes'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.home', 'description' => 'ver panel de control'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.usuarios.index', 'description' => 'ver listado de usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.usuarios.edit', 'description' => 'asignar un rol'])->syncRoles([$role1]);


        Permission::create(['name' => 'admin.cocina.index', 'description' => 'ver cocina'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.movimientos.index', 'description' => 'ver movimientos vista'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.categorias.index', 'description' => 'ver listado de categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.create', 'description' => 'crear categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.edit', 'description' => 'editar categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.delete', 'description' => 'eliminar categorias'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.formas-pago.index', 'description' => 'ver listado de las formas de pago'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.formas-pago.create', 'description' => 'crear una forma de pago'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.formas-pago.edit', 'description' => 'editar una forma de pago'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.formas-pago.delete', 'description' => 'eliminar una forma de pago'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.promociones.index', 'description' => 'ver listado de promociones'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.productos.index', 'description' => 'ver listado de productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.create', 'description' => 'crear productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.edit', 'description' => 'editar productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.delete', 'description' => 'eliminar productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.reportes', 'description' => 'ver reportes productos'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.platos.index', 'description' => 'ver listado de platos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.platos.create', 'description' => 'crear platos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.platos.edit', 'description' => 'editar platos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.platos.delete', 'description' => 'eliminar platos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.platos.reportes', 'description' => 'ver reportes platos'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.clientes.index', 'description' => 'ver listado de clientes'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.clientes.create', 'description' => 'crear clientes'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.clientes.edit', 'description' => 'editar clientes'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.clientes.delete', 'description' => 'eliminar clientes'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.clientes.reportes', 'description' => 'ver clientes'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.empleados.index', 'description' => 'ver listado de empleados'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.empleados.create', 'description' => 'crear empleados'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.empleados.edit', 'description' => 'editar empleados'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.empleados.delete', 'description' => 'eliminar empleados'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.empleados.reportes', 'description' => 'ver reportes empleados'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.proveedores.index', 'description' => 'ver listado de proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.proveedores.create', 'description' => 'crear proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.proveedores.edit', 'description' => 'editar proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.proveedores.delete', 'description' => 'eliminar proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.proveedores.reportes', 'description' => 'ver reportes proveedores'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.compra.index', 'description' => 'ver listado de compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compra.show', 'description' => 'editar compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compra.anular', 'description' => 'anular compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compra.proveedor', 'description' => 'ver proveedores de las compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compra.store', 'description' => 'crear compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compra.reportes', 'description' => 'ver reportes compras'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compra.ticket', 'description' => 'ver ticket de compra'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.gastos.index', 'description' => 'ver listado de gastos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.gastos.create', 'description' => 'crear gastos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.gastos.edit', 'description' => 'editar gastos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.gastos.delete', 'description' => 'eliminar gastos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.gastos.reportes', 'description' => 'ver reportes gastos'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.venta.index', 'description' => 'ver listado de ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.venta.reportes', 'description' => 'reportes de ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.venta.anular', 'description' => 'anular ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.venta.store', 'description' => 'crear ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.venta.show', 'description' => 'ver ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.venta.ticket', 'description' => 'ver ticket de ventas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.reservas.index', 'description' => 'ver listado de reservas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.reservas.reportes', 'description' => 'reportes de reservas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.reservas.anular', 'description' => 'anular reservas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.reservas.store', 'description' => 'crear reservas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.reservas.show', 'description' => 'ver reservas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.reservas.ticket', 'description' => 'ver ticket de reservas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.cajas.index', 'description' => 'ver listado de ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.cajas.create', 'description' => 'crear ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.cajas.update', 'description' => 'editar ventas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.cajas.reportes', 'description' => 'ver ventas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.compania.index', 'description' => 'ver compañia'])->assignRole($role1);
        Permission::create(['name' => 'admin.compania.update', 'description' => 'actualizar compañia'])->assignRole($role1);
    }
}

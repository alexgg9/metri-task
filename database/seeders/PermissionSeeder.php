<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'projects' => ['view', 'create', 'edit', 'delete'],
            'tasks'    => ['assign', 'view', 'create', 'edit', 'delete'],
            'users'    => ['create', 'edit', 'delete', 'view'],
            'admin'    => ['panel'],
        ];

        // Crear todos los permisos
        foreach ($permissions as $entity => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "$action $entity",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Crear roles
        $admin   = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $member  = Role::firstOrCreate(['name' => 'member']);

        // Asignar permisos a roles
        $admin->syncPermissions(Permission::all());

        $manager->syncPermissions([
            'view projects',
            'create projects',
            'edit projects',
            'assign tasks',
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            'view users',
        ]);

        $member->syncPermissions([
            'view projects',
            'view tasks',
            'create tasks',
            'edit tasks',
        ]);

        $this->command->info('Roles y permisos creados correctamente.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleNPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'api']);
        $admin      = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'api']);
        $writer     = Role::firstOrCreate(['name' => 'Writer', 'guard_name' => 'api']);

        foreach (config('permission.permissions') as $permission) {
            $createPermission = Permission::firstOrCreate([
                'name'       => $permission['name'],
                'guard_name' => $permission['guard'],
            ], [
                'route' => $permission['route'],
            ]);
            $superAdmin->givePermissionTo($createPermission);
            $admin->givePermissionTo($createPermission);
            $writer->givePermissionTo($writer);
        }
    }
}

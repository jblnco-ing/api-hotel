<?php

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'rooms.index']);
        Permission::create(['name' => 'rooms.update']);
        Permission::create(['name' => 'rooms.show']);
        Permission::create(['name' => 'rooms.store']);
        Permission::create(['name' => 'rooms.delete']);
        Permission::create(['name' => 'employee.store']);
        Permission::create(['name' => 'employee.delete']);
        Permission::create(['name' => 'record.delete']);
        Permission::create(['name' => 'record.update']);

        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());
        $employee = Role::create(['name' => 'Employee']);
        $employee->givePermissionTo([
            'rooms.index',
            'rooms.update',
            'rooms.show',
            'record.update',
        ]);
        $client = Role::create(['name' => 'Client']);
        $client->givePermissionTo([
            'rooms.index',
            'rooms.show',
        ]);
    }
}

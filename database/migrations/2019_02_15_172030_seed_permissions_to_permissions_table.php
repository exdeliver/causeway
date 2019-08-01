<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedPermissionsToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (null === Role::where('name', 'admin')->first()) {
            Role::create([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);
        }
        if (null === Role::where('name', 'user')->first()) {
            Role::create([
                'name' => 'user',
                'guard_name' => 'web',
            ]);
        }

        if (null === Permission::where('name', 'manage.group')->first()) {
            $permission = Permission::create([
                'name' => 'manage.group',
            ]);
        }

        $role = Role::where('name', 'user')->first();

        if (isset($role)) {
            $role->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Not implemented...
    }
}

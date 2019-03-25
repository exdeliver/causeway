<?php

use Illuminate\Database\Migrations\Migration;

class SeedPermissionsToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Spatie\Permission\Models\Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        \Spatie\Permission\Models\Role::create([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        $permission = \Spatie\Permission\Models\Permission::create([
            'name' => 'manage.group',
        ]);

        $role = \Spatie\Permission\Models\Role::where('name', 'user')->first();

        if (isset($role)) {
            $role->givePermissionTo($permission);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Not implemented...
    }
}

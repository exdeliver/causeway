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
        if (\Spatie\Permission\Models\Role::where('name', 'admin')->first() === null) {
            \Spatie\Permission\Models\Role::create([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);
        }
        if (\Spatie\Permission\Models\Role::where('name', 'user')->first() === null) {
            \Spatie\Permission\Models\Role::create([
                'name' => 'user',
                'guard_name' => 'web',
            ]);
        }

        if (\Spatie\Permission\Models\Permission::where('name', 'manage.group')->first() === null) {
            $permission = \Spatie\Permission\Models\Permission::create([
                'name' => 'manage.group',
            ]);
        }

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

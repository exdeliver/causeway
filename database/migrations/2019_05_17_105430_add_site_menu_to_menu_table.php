<?php

use Exdeliver\Causeway\Domain\Entities\Menu\Menu;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UpdatePagesTable.
 */
class AddSiteMenuToMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $name = 'Site menu';

        Menu::firstOrCreate([
            'label' => $name,
            'name' => str_slug($name),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Not implemented...
    }
}

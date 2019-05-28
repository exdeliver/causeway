<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class UpdatePagesTable
 */
class AddSiteMenuToMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $name = 'Site menu';

        \Exdeliver\Causeway\Domain\Entities\Menu\Menu::firstOrCreate([
            'label' => $name,
            'name' => str_slug($name),
        ]);
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

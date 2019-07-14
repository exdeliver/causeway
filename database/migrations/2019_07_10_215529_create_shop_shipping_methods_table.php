<?php

use Exdeliver\Causeway\Domain\Entities\Shop\ShippingMethods\ShippingMethods;
use Exdeliver\Causeway\Domain\Services\MyParcelService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateShopShippingMethodsTable
 */
class CreateShopShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_shipping_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('service')->nullable();
            $table->string('package_type')->nullable();
            $table->integer('min_weight')->nullable();
            $table->integer('max_weight')->nullable();
            $table->integer('gross_price')->nullable();
            $table->integer('total_free_shipping_threshold')->nullable();
            $table->decimal('vat')->nullable();
            $table->boolean('active')->default(0);

            $table->timestamps();
        });

        $pickUp = 'Pick up';
        ShippingMethods::create([
            'label' => $pickUp,
            'name' => str_slug($pickUp),
            'gross_price' => 0,
            'vat' => 0,
            'active' => true,
        ]);

        $shippingPackage = 'Shipping package';
        ShippingMethods::create([
            'label' => $shippingPackage,
            'name' => str_slug($shippingPackage),
            'service' => MyParcelService::TYPE,
            'package_type' => MyParcelService::PACKAGE_DEFAULT,
            'min_weight' => 0,
            'max_weight' => 2300,
            'gross_price' => 595 / 100,
            'vat' => 21,
            'active' => false,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shop_shipping_methods');
    }
}

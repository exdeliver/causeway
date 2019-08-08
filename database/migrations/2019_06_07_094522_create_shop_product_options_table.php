<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateShopBookingDatesTable.
 */
class CreateShopProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // May be size, color, type of harddrive (SSD or Sata?)
        Schema::create('shop_product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->integer('sequence');
            $table->string('value_type')->default('text');
        });

        Schema::create('shop_product_attribute_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')
                ->references('id')
                ->on('shop_product_attributes')
                ->onDelete('cascade');
            $table->string('attribute_value');
            $table->string('slug')->unique();
            $table->integer('sequence');
        });

        // May be size, color, type of harddrive (SSD or Sata?)
        Schema::create('shop_product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('sequence');
            $table->string('value_type')->default('text');
        });

        Schema::create('shop_product_variant_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('variant_id')->unsigned();
            $table->foreign('variant_id')
                ->references('id')
                ->on('shop_product_variants')
                ->onDelete('cascade');
            $table->string('variant_value');
            $table->string('slug')->unique();
            $table->integer('sequence');
        });

        Schema::create('shop_product_variant_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
        });

        Schema::create('shop_product_variant_value_product', function (Blueprint $table) {
            $table->integer('variant_value_id')->unsigned();
            $table->foreign('variant_value_id')
                ->references('id')
                ->on('shop_product_variant_values')
                ->onDelete('cascade');
            $table->integer('variant_product_id')->unsigned();
            $table->foreign('variant_product_id')
                ->references('id')
                ->on('shop_product_variant_products')
                ->onDelete('cascade');
        });

        Schema::table('shop_products', function (Blueprint $table) {
            $table->integer('parent_product_id')->unsigned()->nullable();
            $table->foreign('parent_product_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('shop_product_attributes');
        Schema::drop('shop_product_attribute_values');
        Schema::drop('shop_product_variants');
        Schema::drop('shop_product_variant_values');
    }
}

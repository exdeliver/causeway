<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateShopProductBookingDatesTable.
 */
class CreateShopProductBookingDatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shop_product_booking_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->integer('gross_price')->nullable();
            $table->integer('special_price')->nullable();
        });

        Schema::create('order_booking_dates', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->boolean('active')->default(0);
            $table->integer('quantity')->nullable();
            $table->integer('booking_date_id');
            $table->index(['booking_date_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('shop_product_booking_dates');
        Schema::drop('order_booking_dates');
    }
}

<?php

use Exdeliver\Causeway\Domain\Entities\Shop\CouponCode;
use Exdeliver\Causeway\Domain\Entities\Shop\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateShopModels
 */
class CreateShopModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Categories
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')
                ->nullable()
                ->references('id')
                ->on('shop_categories')
                ->onDelete('set null');
            $table->string('title');
            $table->string('slug');
            $table->boolean('active')->default(1);
            $table->text('description')->nullable();
            $table->string('media')->nullable();
            $table->integer('sequence')->nullable();
            $table->timestamps();
        });

        // Products
        Schema::create('shop_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pid')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('type')->default(Product::REGULAR_PRODUCT['type']);
            $table->boolean('active')->default(1);
            $table->text('description')->nullable();
            $table->integer('sequence')->nullable();

            $table->string('weight')->nullable();

            // Pricing
            $table->integer('quantity');
            $table->integer('gross_price');
            $table->integer('special_price')->nullable();
            $table->decimal('vat');

            $table->timestamps();
        });

        Schema::create('shop_products_medias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
            $table->string('media');
            $table->timestamps();
        });

        // Link above
        Schema::create('shop_category_product', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('shop_categories')
                ->onDelete('cascade');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->unsigned()
                ->references('id')
                ->on('shop_products')
                ->onDelete('cascade');
        });

        // Customers
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->integer('order_id')->index()->nullable();
            $table->timestamps();
        });

        // Contacts
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->boolean('primary');
            $table->string('type')->index()->nullable();
            $table->string('gender')->nullable();
            $table->string('company')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_suffix')->nullable();
            $table->string('zipcode')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->string('uuid');
            $table->string('payment_method');
            $table->string('status')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('mollie_payment_total')->nullable();
            $table->string('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->string('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->string('name')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('type');
            $table->integer('quantity');
            $table->integer('gross_price');
            $table->string('discount_type');
            $table->integer('discount_amount');
            $table->decimal('vat');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->string('service');
            $table->timestamps();
        });

        Schema::create('shop_coupon_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('coupon_code');
            $table->text('description')->nullable();
            $table->string('discount_type')->default(CouponCode::FIXED_PRICE_DISCOUNT);
            $table->string('discount_amount');
            $table->boolean('active')->default(1);
            $table->integer('quantity')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shop_categories');
        Schema::drop('shop_products');
        Schema::drop('shop_product_medias');
        Schema::drop('shop_category_product');
        Schema::drop('customers');
        Schema::drop('contacts');
        Schema::drop('orders');
        Schema::drop('invoices');
        Schema::drop('order_lines');
        Schema::drop('payments');
    }
}

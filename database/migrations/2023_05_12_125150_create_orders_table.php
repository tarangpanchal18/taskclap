<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('provider_id')->nullable()->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->references('id')->on('categories');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('pincode');
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('area_id')->constrained();
            $table->string('address_lat')->nullable();
            $table->string('address_long')->nullable();
            $table->integer('product_count');
            $table->enum('isPromoApplied', ['Yes', 'No'])->default('No');
            $table->string('promocode')->nullable();
            $table->float('discount')->nullable()->comment('Promocode discount, Other discount');
            $table->float('tax')->nullable();
            $table->float('material_charge_amount_total')->nullable();
            $table->float('additional_charge_amount_total')->nullable();
            $table->float('provider_pay_amount_total')->nullable();
            $table->float('system_earn_amount_total')->nullable();
            $table->float('subtotal')->comment('without taxes, discount, etc.');
            $table->float('total')->comment('including taxes, discount, etc.');
            $table->float('cancellation_charge')->nullable();
            $table->enum('is_warranty_order', ['Yes', 'No'])->default('No');
            $table->enum('payment_type', ['Cash', 'Card', 'NetBanking', 'Upi'])->nullable();
            $table->json('payment_json')->nullable();
            $table->enum('payment_status', ['Started', 'Pending', 'Completed', 'Failed']);
            $table->enum('order_status', ['Placed', 'Completed', 'Pending', 'Cancelled', 'Failed', 'Rejected']);
            $table->text('order_notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
};

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
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('address');
            $table->string('pincode');
            $table->string('address_lat')->nullable();
            $table->string('address_long')->nullable();
            $table->integer('product_count');
            $table->enum('isPromoApplied', ['Yes', 'No']);
            $table->string('promocode')->nullable();
            $table->float('discount')->nullable()->comment('Promocode discount, Other discount');
            $table->float('tax')->nullable();
            $table->float('subtotal')->comment('without taxes, discount, etc.');
            $table->float('total')->comment('including taxes, discount, etc.');
            $table->enum('payment_type', ['Cash', 'NetBanking', 'Upi']);
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

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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('order');
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->references('id')->on('categories');
            $table->foreignId('service_category_id')->constrained();
            $table->string('product_title');
            $table->text('product_description');
            $table->float('product_strike_price', 8, 2);
            $table->float('material_charge')->nullable();
            $table->text('material_description')->nullable();
            $table->float('additional_charge')->nullable();
            $table->text('additional_charge_description')->nullable();
            $table->float('product_price', 8, 2);
            $table->float('product_commission', 8, 2);
            $table->integer('warranty')->comment('in days');
            $table->string('product_approx_duration');
            $table->enum('order_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->string('order_note');
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
        Schema::dropIfExists('order_details');
    }
};

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->text('long_description')->nullable();
            $table->text('image')->nullable();
            $table->float('price', 8, 2);
            $table->integer('commission');
            $table->string('approx_duration')->comment("Approx Time to complete")->nullable();
            $table->enum('status', ['Active','InActive'])->default('Active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sub_category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

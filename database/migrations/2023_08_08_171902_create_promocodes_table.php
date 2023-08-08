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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('promocode');
            $table->text('description');
            $table->enum('disount_type', ['Flat', 'Percentage'])->default('Flat');
            $table->enum('validity', ['Permanent', 'Dynamic'])->default('Permanent');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->enum('type', ['Public', 'Private'])->default('Public');
            $table->float('value');
            $table->integer('limit')->nullable();
            $table->enum('status', ['Active', 'InActive'])->default('Active');
            $table->softDeletes();
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
        Schema::dropIfExists('promocodes');
    }
};

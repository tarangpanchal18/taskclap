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
        Schema::create('user_authentication_logs', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('authenticatable_type')->nullable();
            $table->bigInteger('authenticatable_id')->unsigned()->nullable();
            $table->string('ip_address');
            $table->text('user_agent')->comment('Browser Detail');
            $table->datetime('login_at')->nullable();
            $table->enum('login_successful', ['Yes', 'No'])->default('No');
            $table->string('logout_at')->nullable();
            $table->json('location')->nullable();
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
        Schema::dropIfExists('user_authentication_logs');
    }
};

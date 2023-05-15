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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->after('phone')->nullable();
            $table->unsignedBigInteger('state_id')->after('country_id')->nullable();
            $table->unsignedBigInteger('city_id')->after('state_id')->nullable();
            $table->unsignedBigInteger('area_id')->after('city_id')->nullable();
            $table->string('address_lat')->after('area_id')->nullable();
            $table->string('address_long')->after('address_lat')->nullable();
            $table->string('is_blocked')->after('remember_token')->default('No');

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_country_id_foreign');
            $table->dropForeign('users_state_id_foreign');
            $table->dropForeign('users_city_id_foreign');
            $table->dropForeign('users_area_id_foreign');

            $table->dropColumn('country_id');
            $table->dropColumn('state_id');
            $table->dropColumn('city_id');
            $table->dropColumn('area_id');
            $table->dropColumn('address_lat');
            $table->dropColumn('address_long');
        });
    }
};

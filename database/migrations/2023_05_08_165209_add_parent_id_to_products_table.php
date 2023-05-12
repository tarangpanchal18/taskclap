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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('service_category_id')->nullable()->after('sub_category_id')->onDelete('cascade')->onUpdate('cascade');
            $table->float('strike_price', 8, 2)->default(0)->after('image');

            $table->foreign('parent_id')->references('id')->on('products');
            $table->foreign('service_category_id')->references('id')->on('service_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_parent_id_foreign');
            $table->dropForeign('products_service_category_id_foreign');

            $table->dropColumn('parent_id');
            $table->dropColumn('service_category_id');
            $table->dropColumn('strike_price');
        });
    }
};

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
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->enum('service_type', [
                'Service',
                'Repair',
                'InstallUninstall'
            ])->nullable()->after('sub_category_id');
            $table->float('strike_price', 8, 2)->default(0)->after('image');

            $table->foreign('parent_id')->references('id')->on('products');
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
            $table->dropColumn([
                'parent_id',
                'service_type',
                'strike_price',
            ]);
        });
    }
};

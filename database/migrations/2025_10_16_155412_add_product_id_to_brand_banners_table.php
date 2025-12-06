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
        Schema::table('brand_banners', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('brand_id')->constrained('products')->onDelete('cascade');
            $table->enum('launch_type', ['brand', 'product', 'website'])->default('brand')->after('own_banner')->comment('brand', 'product', 'website');
            $table->text('website')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_banners', function (Blueprint $table) {
            //
        });
    }
};

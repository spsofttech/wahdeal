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
           $table->enum('own_banner', ['0', '1'])->default('0')->after('brand_id')->comment('0=>Not Own, 1=>Own');
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
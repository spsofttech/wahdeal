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
        Schema::table('branches', function (Blueprint $table) {
            $table->string('whatsapp_no')->nullable()->after('contact_no');
            $table->text('facebook')->nullable()->after('address');
            $table->text('twitter')->nullable()->after('facebook');
            $table->text('instagram')->nullable()->after('twitter');
            $table->text('linkedin')->nullable()->after('instagram');
            $table->text('pinterest')->nullable()->after('linkedin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('month')->nullable();
            $table->string('old_amount')->nullable();
            $table->string('latest_amount')->nullable();
            $table->string('discount_text')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0=>Deactive, 1=>Active');
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
        Schema::dropIfExists('plans');
    }
};

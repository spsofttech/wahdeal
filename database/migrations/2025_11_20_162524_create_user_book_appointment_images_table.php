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
        Schema::create('user_book_appointment_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_book_appointment_id')->nullable()->constrained('user_book_appointments')->onDelete('cascade');
            $table->foreignId('category_field_id')->nullable()->constrained('category_fields')->onDelete('cascade');
            $table->text('image')->nullable();
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
        Schema::dropIfExists('user_book_appointment_images');
    }
};

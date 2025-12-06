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
        Schema::table('user_book_appointments', function (Blueprint $table) {
            $table->foreignId('booking_cancel_reason_id')->nullable()->after('book_status')->constrained('booking_cancel_reasons')->onDelete('cascade');
             $table->text('booking_cancel_reason_other')->nullable()->after('booking_cancel_reason_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_book_appointments', function (Blueprint $table) {
            //
        });
    }
};

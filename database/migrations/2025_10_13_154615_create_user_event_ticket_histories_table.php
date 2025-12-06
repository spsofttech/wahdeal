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
        Schema::create('user_event_ticket_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_event_ticket_id')->nullable()->constrained('user_event_tickets')->onDelete('cascade');
            $table->string('day')->nullable();
            $table->string('card')->nullable();
            $table->string('price')->nullable();
            $table->date('event_date')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('user_event_ticket_histories');
    }
};

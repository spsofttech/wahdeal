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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_address_id')->nullable()->constrained('user_addresses')->onDelete('cascade');
            $table->foreignId('coupon_code_id')->nullable()->constrained('coupon_codes')->onDelete('cascade');
            $table->text('order_number')->unique();
            $table->decimal('total', 10, 2)->default(0);
            $table->text('charge')->nullable();
            $table->integer('payment_method')->default('1')->comment('1=>COD, 2=>Online, 3=>Wallet');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->comment('pending,paid,failed');
            $table->integer('order_status')->default('1')->comment('1=>Confirmed, 2=>Shipped, 3=>On the Way, 4=>Delivered, 5=> Cancelled, 6=>Return, 7=>Complete');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};

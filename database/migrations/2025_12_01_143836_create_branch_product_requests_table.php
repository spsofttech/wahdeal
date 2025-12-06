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
        Schema::create('branch_product_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade');
            $table->string('branch_id')->nullable();
            $table->string('product_id')->nullable();
            $table->longText('about')->nullable();
            $table->longText('product')->nullable();
            $table->longText('product_images')->nullable();
            $table->longText('product_colors')->nullable();
            $table->longText('product_sizes')->nullable();
            $table->longText('product_size_color_prices')->nullable();
            $table->longText('offers')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfExists('branch_product_requests');
    }
};

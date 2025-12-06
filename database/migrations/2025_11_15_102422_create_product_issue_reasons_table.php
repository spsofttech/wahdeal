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
        Schema::create('product_issue_reasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_issue_category_id')->nullable()->constrained('product_issue_categories')->onDelete('cascade');
            $table->text('title')->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment('0=>Deactive, 1=>Active');
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
        Schema::dropIfExists('product_issue_reasons');
    }
};

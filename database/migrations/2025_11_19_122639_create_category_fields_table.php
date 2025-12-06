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
        Schema::create('category_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->text('label')->nullable();
            $table->text('name')->nullable();
            $table->string('type')->nullable();
            $table->text('options')->nullable();
            $table->text('options_selection')->nullable();
            $table->enum('is_required', ['0', '1'])->default('0')->comment('0=>not_required, 1=>is_required');
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['0', '1'])->default('1')->comment('0=>Deactive, 1=>Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_fields');
    }
};

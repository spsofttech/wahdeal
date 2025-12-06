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
        Schema::table('order_details', function (Blueprint $table) {
           $table->decimal('gst', 10, 2)->default(0)->after('price');  
           $table->decimal('gst_price', 10, 2)->default(0)->after('gst');
           $table->integer('order_status')->default('1')->after('final_price')->comment('1=>Confirmed, 2=>Shipped, 3=>On the Way, 4=>Delivered, 5=> Cancelled, 6=>Return, 7=>Complete');
           $table->text('cancel_reason')->nullable()->after('order_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            //
        });
    }
};

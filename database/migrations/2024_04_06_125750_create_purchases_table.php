<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('v_code');//vendor code
            $table->string('v_name');//vendor name
            $table->integer('p_code');//product code
            $table->string('p_name');//product name
            $table->integer('t_qty')->default(1);
            $table->integer('p_rate');//purchased price per item
            $table->integer('p_discount');//discount on purchases
            $table->integer('t_bill')->default(1); //total bill amount of purchase
            $table->integer('cash')->default(0);//paid via cash
            $table->integer('bank')->default(0);//paid via bank transfer
            $table->integer('balance')->default(0);//remaining balance to be paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

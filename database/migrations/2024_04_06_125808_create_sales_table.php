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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_code');//vendor code
            $table->string('cust_name');//vendor name
            $table->integer('pr_code');//product code
            $table->string('p_name');//product name
            $table->integer('t_qty')->default(1);
            $table->integer('p_rate');//purchased price per item
            $table->integer('p_discount');//discount on purchases
            $table->integer('tp_bill');//total bill
            $table->integer('cash');//paid via cash
            $table->integer('bank');//paid via bank transfer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

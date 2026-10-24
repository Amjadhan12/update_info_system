<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bill_id')->constrained('sale_bills')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('unit_size');
            $table->float('qty');
            $table->decimal('price',12,4);
            $table->decimal('pprice',12,4)->default(0);
            $table->float('discount')->default(0);
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
        Schema::dropIfExists('sales');
    }
}

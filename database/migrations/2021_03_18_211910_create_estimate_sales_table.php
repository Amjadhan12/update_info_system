<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bill_id')->constrained('estimate_sale_bills')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('qty');
            $table->float('price');
            $table->float('pprice')->default(0);
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
        Schema::dropIfExists('estimate_sales');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('from_stock_id')->constrained('stocks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('to_stock_id')->constrained('stocks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('unit_size');
            $table->float('qty');
            $table->date('date');
            $table->text('details')->nullable();
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
        Schema::dropIfExists('stock_transfers');
    }
}

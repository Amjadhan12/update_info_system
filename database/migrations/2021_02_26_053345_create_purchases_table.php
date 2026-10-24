<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('purchase_bills')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('stock_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('unit_size');
            $table->float('qty');
            $table->decimal('pprice',12,4);
            $table->decimal('sprice',12,4);
            $table->date('exp_date')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}

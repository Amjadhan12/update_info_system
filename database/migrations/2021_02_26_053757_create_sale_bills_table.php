<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('curRate', 10, 4);
            $table->string("bill_no")->nullable();
            $table->decimal('over_exp', 10, 4)->default(0);
            $table->float('discount')->default(0);
            $table->date('date');
            $table->longText('details')->nullable();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('sale_bills');
    }
}

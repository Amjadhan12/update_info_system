<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateSaleBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_sale_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('curRate');
            $table->string("bill_no")->nullable();
            $table->float('over_exp')->default(0);
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
        Schema::dropIfExists('estimate_sale_bills');
    }
}

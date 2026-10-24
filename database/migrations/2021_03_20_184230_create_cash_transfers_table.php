<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account_id');
            $table->foreignId('to_account_id');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('curRate');
            $table->float('amount');
            $table->date("date");
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
        Schema::dropIfExists('cash_transfers');
    }
}

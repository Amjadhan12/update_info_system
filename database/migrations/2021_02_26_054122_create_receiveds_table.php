<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiveds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_account_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('curRate', 10, 4);
            $table->string('rasid_no');
            $table->decimal('amount', 14, 4);
            $table->date('date');
            $table->longText('details')->nullable();
            $table->bigInteger('optional_bill')->default(0);
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
        Schema::dropIfExists('receiveds');
    }
}

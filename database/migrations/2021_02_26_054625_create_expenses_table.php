<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_account_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('expense_category_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('curRate',12,4);
            $table->decimal('amount',12,4);
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
        Schema::dropIfExists('expenses');
    }
}

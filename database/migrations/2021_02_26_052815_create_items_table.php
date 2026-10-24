<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('currency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('curRate',12,4);
            $table->string('barcode', 190)->nullable();
            $table->string('name', 190);
            $table->float('pprice')->default(0);
            $table->float('sprice')->default(0);
            $table->longText('details')->nullable();
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
        Schema::dropIfExists('items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title_pa', 190);
            $table->string('title_en', 190);
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->text('image_path')->nullable();
            $table->text('address')->nullable();
            $table->text('bill_text')->nullable();
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
        Schema::dropIfExists('settings');
    }
}

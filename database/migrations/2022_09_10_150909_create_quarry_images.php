<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuarryImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarry_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quarry_id')->unsigned();
            $table->text('image');
            $table->timestamps();
            $table->foreign('quarry_id')->references('id')->on('quarries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quarry_images');
    }
}

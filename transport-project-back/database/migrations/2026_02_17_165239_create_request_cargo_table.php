<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('request_cargo', function (Blueprint $table) {
            $table->id('request_cargo_id');
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('cargo_id');
            $table->integer('quantity');
            $table->string('unit');
            $table->timestamps();
            
            $table->foreign('request_id')->references('request_id')->on('requests')->onDelete('cascade');
            $table->foreign('cargo_id')->references('cargo_id')->on('cargo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_cargo');
    }
};
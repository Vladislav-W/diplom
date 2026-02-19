<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('distances', function (Blueprint $table) {
            $table->id('distance_id');
            $table->unsignedBigInteger('departure_city_id');
            $table->unsignedBigInteger('arrival_city_id');
            $table->decimal('distance', 10, 2);
            $table->foreign('departure_city_id')->references('city_id')->on('cities');
            $table->foreign('arrival_city_id')->references('city_id')->on('cities');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distances');
    }
};
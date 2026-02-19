<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auto_park', function (Blueprint $table) {
            $table->id('auto_id');
            $table->string('auto_name');
            $table->string('state_number')->unique();
            $table->decimal('capacity', 10, 2);
            $table->integer('driver_tab_number')->unique();
            $table->foreign('driver_tab_number')->references('driver_tab_number')->on('drivers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('auto_park');
    }
};
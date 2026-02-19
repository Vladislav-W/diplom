<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('responsible_people', function (Blueprint $table) {
            $table->id('responsible_person_id');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('department');
            $table->string('post');
            $table->string('phone_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responsible_people');
    }
};
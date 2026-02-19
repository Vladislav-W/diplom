<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('request_number')->unique();
            $table->string('status');
            $table->timestamps();
            
            // Пункт погрузки
            $table->unsignedBigInteger('organization_from_id');
            $table->unsignedBigInteger('departure_city_id');
            $table->string('address_from');
            $table->text('notes_from')->nullable();
            
            // Пункт разгрузки
            $table->unsignedBigInteger('organization_to_id');
            $table->unsignedBigInteger('arrival_city_id');
            $table->string('address_to');
            $table->text('notes_to')->nullable();
            
            // Даты
            $table->dateTime('departure_datetime');
            $table->dateTime('arrival_datetime');
            
            // Авто и водитель
            $table->unsignedBigInteger('auto_id');
            $table->unsignedBigInteger('driver_id');
            
            // Ответственный
            $table->unsignedBigInteger('responsible_person_id');
            
            // Доверенность
            $table->boolean('attorney_for_driver')->default(false);
            
            // Внешние ключи
            $table->foreign('organization_from_id')->references('organization_id')->on('organizations');
            $table->foreign('organization_to_id')->references('organization_id')->on('organizations');
            $table->foreign('departure_city_id')->references('city_id')->on('cities');
            $table->foreign('arrival_city_id')->references('city_id')->on('cities');
            $table->foreign('auto_id')->references('auto_id')->on('auto_park');
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->foreign('responsible_person_id')->references('responsible_person_id')->on('responsible_people');
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
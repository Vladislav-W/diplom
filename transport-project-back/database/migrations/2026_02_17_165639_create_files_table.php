<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id('file_id');
            $table->unsignedBigInteger('request_id');
            $table->string('file_name');        // оригинальное имя файла
            $table->string('file_type');         // MIME-тип (image/jpeg, application/pdf и т.д.)
            $table->binary('file_data');         // сами данные файла
            $table->integer('file_size');        // размер в байтах
            $table->timestamps();
            
            $table->foreign('request_id')->references('request_id')->on('requests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
};
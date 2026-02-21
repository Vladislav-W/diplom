<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            // Делаем поля nullable для авто и водителя
            $table->unsignedBigInteger('auto_id')->nullable()->change();
            $table->unsignedBigInteger('driver_id')->nullable()->change();
            $table->unsignedBigInteger('responsible_person_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('auto_id')->nullable(false)->change();
            $table->unsignedBigInteger('driver_id')->nullable(false)->change();
            $table->unsignedBigInteger('responsible_person_id')->nullable(false)->change();
        });
    }
};

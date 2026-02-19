<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cargo', function (Blueprint $table) {
            $table->id('cargo_id');
            $table->string('cargo_name');
            $table->date('date_of_taking_cargo');
            $table->string('type_of_packaging');
            $table->decimal('weight_of_cargo', 10, 2);
            $table->decimal('cargo_volume', 10, 2);
            $table->integer('quantity');
            $table->string('cargo_unit');
            $table->string('danger_class')->nullable();
            $table->dateTime('delivery_time');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cargo');
    }
};
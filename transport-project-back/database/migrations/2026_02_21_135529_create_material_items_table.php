<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material_items', function (Blueprint $table) {
            $table->id('material_item_id');
            $table->unsignedBigInteger('cargo_id');
            $table->string('name');
            $table->integer('quantity');
            $table->string('unit');
            $table->timestamps();

            $table->foreign('cargo_id')->references('cargo_id')->on('cargo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_items');
    }
};

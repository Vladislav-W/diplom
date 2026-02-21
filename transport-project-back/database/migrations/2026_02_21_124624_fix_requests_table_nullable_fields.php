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
        Schema::table('requests', function (Blueprint $table) {
            // Делаем поля nullable
            $table->unsignedBigInteger('organization_from_id')->nullable()->change();
            $table->unsignedBigInteger('departure_city_id')->nullable()->change();
            $table->string('address_from')->nullable()->change();
            
            $table->unsignedBigInteger('organization_to_id')->nullable()->change();
            $table->unsignedBigInteger('arrival_city_id')->nullable()->change();
            $table->string('address_to')->nullable()->change();
            
            $table->dateTime('departure_datetime')->nullable()->change();
            $table->dateTime('arrival_datetime')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_from_id')->nullable(false)->change();
            $table->unsignedBigInteger('departure_city_id')->nullable(false)->change();
            $table->string('address_from')->nullable(false)->change();
            
            $table->unsignedBigInteger('organization_to_id')->nullable(false)->change();
            $table->unsignedBigInteger('arrival_city_id')->nullable(false)->change();
            $table->string('address_to')->nullable(false)->change();
            
            $table->dateTime('departure_datetime')->nullable(false)->change();
            $table->dateTime('arrival_datetime')->nullable(false)->change();
        });
    }
};

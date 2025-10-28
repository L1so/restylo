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
        Schema::create('outfit_combinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('top');
            $table->string('bottom');
            $table->string('shoes');
            $table->enum('weather_condition', ['sunny', 'rainy', 'cloudy', 'cold']);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfit_combinations');
    }
};

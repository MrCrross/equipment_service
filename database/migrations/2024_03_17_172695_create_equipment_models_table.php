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
        Schema::create('equipment_model', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('brand_id');
            $table->foreignId('creator_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')->on('equipment_brands')->references('id');
            $table->foreign('creator_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_model');
    }
};

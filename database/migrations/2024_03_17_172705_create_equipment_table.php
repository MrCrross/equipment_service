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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id');
            $table->foreignId('model_id');
            $table->string('short_name');
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->on('equipment_types')->references('id');
            $table->foreign('model_id')->on('equipment_models')->references('id');
            $table->foreign('creator_id')->on('users')->references('id');
            $table->foreign('editor_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};

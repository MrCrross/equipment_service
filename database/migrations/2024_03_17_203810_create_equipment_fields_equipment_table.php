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
        Schema::create('equipment_fields_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id');
            $table->foreignId('field_id');
            $table->string('value')->default('');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['equipment_id', 'field_id']);
            $table->foreign('equipment_id')->on('equipment')->references('id');
            $table->foreign('field_id')->on('equipment_fields')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_fields_equipment');
    }
};

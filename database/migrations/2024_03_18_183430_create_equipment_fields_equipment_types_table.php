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
        Schema::create('equipment_fields_equipment_types', function (Blueprint $table) {
            $table->foreignId('type_id');
            $table->foreignId('field_id');

            $table->primary(['type_id', 'field_id']);
            $table->foreign('type_id')->on('equipment_types')->references('id');
            $table->foreign('field_id')->on('equipment_fields')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_fields_equipment_types');
    }
};

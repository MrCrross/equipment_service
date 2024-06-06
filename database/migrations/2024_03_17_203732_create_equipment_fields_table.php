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
        Schema::create('equipment_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type_code', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_code')->on('equipment_fields_types')->references('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_fields');
    }
};

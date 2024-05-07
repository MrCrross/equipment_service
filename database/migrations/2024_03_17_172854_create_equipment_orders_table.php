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
        Schema::create('equipment_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id');
            $table->foreignId('master_id')->nullable();
            $table->string('status_code', 20);
            $table->text('description');
            $table->string('phone')->nullable();
            $table->string('client_name')->nullable();
            $table->foreignId('client_id')->nullable();
            $table->foreignId('creator_id');
            $table->foreignId('editor_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_id')->on('equipment')->references('id');
            $table->foreign('creator_id')->on('users')->references('id');
            $table->foreign('editor_id')->on('users')->references('id');
            $table->foreign('master_id')->on('users')->references('id');
            $table->foreign('client_id')->on('clients')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_orders');
    }
};

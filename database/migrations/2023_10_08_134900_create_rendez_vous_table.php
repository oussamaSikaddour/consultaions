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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('planning_day_id')->nullable();
            $table->unsignedBigInteger('consultation_place_id')->nullable();
            $table->enum('type', ['normal', 'control'])->default('normal');
            $table->date('day_at');
            $table->string('specialty');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('medical_files')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('planning_day_id')->references('id')->on('planning_days')->onDelete('cascade');
            $table->foreign('consultation_place_id')->references('id')->on('consultation_places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};

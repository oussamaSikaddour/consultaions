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
        Schema::create('planning_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('planning_id');
            $table->unsignedBigInteger('consultation_place_id');
            $table->date('day_at');
            $table->integer('number_of_consultation');
            $table->integer('number_of_rendez_vous')->nullable();
            $table->enum('state', ['complete', 'incomplete'])->default('incomplete');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('planning_id')->references('id')->on('plannings')->onDelete('cascade');
            $table->foreign('consultation_place_id')->references('id')->on('consultation_places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planning_days');
    }
};

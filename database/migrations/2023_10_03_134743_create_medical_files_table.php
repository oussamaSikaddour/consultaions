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
        Schema::create('medical_files', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('code');
            $table->string('email');
            $table->unsignedBigInteger('opened_by');
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date');
            $table->string('address')->nullable();
            $table->string('tel');
            $table->foreign('opened_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_files');
    }
};

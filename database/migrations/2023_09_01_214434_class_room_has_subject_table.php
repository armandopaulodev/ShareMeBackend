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
        Schema::create('class_room_has_subject', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('subject_id');
            // You can add more columns if needed, such as timestamps.
            $table->timestamps();

            // Define foreign keys
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('room_id')->references('id')->on('class_rooms');

            // Add unique constraint to prevent duplicate entries
            $table->unique(['subject_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_room_has_subject');
    }
};

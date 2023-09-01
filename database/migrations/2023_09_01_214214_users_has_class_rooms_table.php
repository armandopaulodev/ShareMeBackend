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
        Schema::create('users_has_class_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('room_id');
            // You can add more columns if needed, such as timestamps.
            $table->timestamps();

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('room_id')->references('id')->on('class_rooms');

            // Add unique constraint to prevent duplicate entries
            $table->unique(['user_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_has_class_rooms');
    }
};

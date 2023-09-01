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
        Schema::create('subject_has_attachment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('attachment_id');

            // You can add more columns if needed, such as timestamps.
            $table->timestamps();

            // Define foreign keys
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('attachment_id')->references('id')->on('class_attachments');

            // Add unique constraint to prevent duplicate entries
            $table->unique(['subject_id', 'attachment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_has_attachment');
    }
};

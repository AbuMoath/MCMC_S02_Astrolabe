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
        Schema::create('agency_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->unsignedBigInteger('agency_id');
            $table->string('agency_name');
            $table->enum('recipient_type', ['User', 'Administrator']);
            $table->text('comment');
            $table->string('supporting_document')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // The user this note is for
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['inquiry_id', 'recipient_type']);
            $table->index(['user_id', 'created_at']);
            $table->index('agency_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_notes');
    }
};
<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_saved_events_table.php

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
        Schema::create('saved_events', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Foreign key to events table
            $table->foreignId('event_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Additional fields if needed
            $table->text('notes')->nullable(); // Optional notes about why the event was saved
            $table->boolean('reminder_set')->default(false); // Whether user set a reminder
            $table->timestamp('reminder_at')->nullable(); // When to remind the user
            
            // Unique constraint to prevent duplicate saves
            $table->unique(['user_id', 'event_id']);
            
            $table->timestamps();
        });

        // Add index for better performance on frequent queries
        Schema::table('saved_events', function (Blueprint $table) {
            $table->index(['user_id', 'created_at']);
            $table->index(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_events');
    }
};
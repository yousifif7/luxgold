<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // info, warning, success, error, system
            $table->string('title');
            $table->text('message');
            $table->text('action_url')->nullable(); // URL for action button
            $table->string('action_text')->nullable(); // Text for action button
            
            // Polymorphic relationship - can belong to user, provider, or be global
            $table->morphs('notifiable');
            
            // For targeting specific user roles
            $table->string('target_role')->nullable(); // admin, provider, parent
            
            // Notification status and timing
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            
            // Additional metadata
            $table->json('metadata')->nullable();
            
            $table->timestamps();

            // Indexes for performance
            $table->index(['notifiable_type', 'notifiable_id', 'read_at']);
            $table->index(['target_role', 'sent_at']);
            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
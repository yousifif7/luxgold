<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_moderation_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('admin_user_id')->nullable();
            $table->string('action');
            $table->text('note')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('review_id');
            $table->index('admin_user_id');

            // Foreign Keys
            $table->foreign('review_id')
                  ->references('id')
                  ->on('reviews')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_moderation_logs');
    }
};

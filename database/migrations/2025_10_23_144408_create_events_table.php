<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->decimal('cost', 10, 2)->default(0.00);
            $table->enum('status', ['active', 'pending', 'cancelled'])->default('pending');
            $table->integer('max_capacity')->nullable();
            $table->integer('current_capacity')->default(0);
            $table->string('age_group')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('image_url')->nullable();
            $table->string('author')->nullable();
            $table->foreignId('provider_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

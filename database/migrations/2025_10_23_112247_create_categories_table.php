<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->integer('providers_count')->default(0);
            $table->string('icon')->nullable();
            $table->json('tags')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('parent_id');
            $table->index('status');
            $table->index('sort_order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
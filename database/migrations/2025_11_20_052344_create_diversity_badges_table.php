<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diversity_badges', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // Badge title
            $table->string('slug')->unique();     // Unique identifier
            $table->string('icon')->nullable();   // Icon path or URL
            $table->text('description')->nullable(); // Badge description
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diversity_badges');
    }
};

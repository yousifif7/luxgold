<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('provider_id')->constrained()->onDelete('cascade');
            $table->integer('rating');
            $table->text('comment');
            $table->enum('status', ['pending', 'approved', 'flagged', 'hidden', 'rejected'])->default('pending');
            $table->timestamps();

            // ✅ Add soft delete column
            $table->softDeletes();

            $table->unique(['user_id', 'provider_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};

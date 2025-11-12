<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('membership')->nullable();
            $table->string('status')->nullable();
            $table->decimal('revenue', 10, 2)->default(0.00);
            $table->decimal('rating', 3, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedInteger('profile_views')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('inquiries')->default(0);
            $table->timestamps();
        });*/
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};

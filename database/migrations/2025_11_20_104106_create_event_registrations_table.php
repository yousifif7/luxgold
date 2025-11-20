<?php
// database/migrations/2023_01_01_create_event_registrations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('guests')->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->string('registration_code')->unique();
            $table->timestamps();
            
            $table->index(['event_id', 'email']);
            $table->index('registration_code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_registrations');
    }
};
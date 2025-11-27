<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hire_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cleaner_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('cleaning_type')->nullable();
            $table->json('selected_items')->nullable();
            $table->string('frequency')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();

            $table->foreign('cleaner_id')->references('id')->on('cleaners')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hire_requests');
    }
};

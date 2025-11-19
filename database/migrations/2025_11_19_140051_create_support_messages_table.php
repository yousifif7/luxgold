<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportMessagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('support_ticket_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('sender_name')->nullable();
            $table->text('message');

            $table->timestamps();

            // Indexes
            $table->index('support_ticket_id');
            $table->index('user_id');

            // Foreign key
            $table->foreign('support_ticket_id')
                  ->references('id')
                  ->on('support_tickets')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_messages');
    }
}

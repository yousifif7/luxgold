<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('subscription_id')->index();
                $table->unsignedBigInteger('cleaner_id')->nullable()->index();
                
                // Payment details
                $table->string('payment_method')->nullable(); // e.g., stripe, paypal
                $table->string('transaction_id')->nullable()->unique();
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('currency', 10)->default('USD');
                $table->string('status')->default('pending'); // pending, completed, failed, refunded
                
                // Optional details
                $table->timestamp('paid_at')->nullable();
                $table->text('meta')->nullable(); // store gateway response or additional info
                
                $table->timestamps();

                // Foreign keys
               /* $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
                $table->foreign('cleaner_id')->references('id')->on('cleaners')->onDelete('cascade');*/
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cleaner_id')->nullable()->index();
            $table->string('plan_id')->nullable();
            $table->string('status')->default('active');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 10)->default('USD');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('renews_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->boolean('is_active')->default(0);
            $table->text('meta')->nullable();
            $table->timestamps();
/*                $table->foreign('cleaner_id')->references('id')->on('cleaners')->onDelete('cascade');
*/            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};

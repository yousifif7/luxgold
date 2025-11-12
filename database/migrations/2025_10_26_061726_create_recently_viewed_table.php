<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_recently_viewed_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentlyViewedTable extends Migration
{
    public function up()
    {
        Schema::create('recently_viewed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('provider_id')->constrained()->onDelete('cascade');
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->unique(['user_id', 'provider_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('recently_viewed');
    }
}
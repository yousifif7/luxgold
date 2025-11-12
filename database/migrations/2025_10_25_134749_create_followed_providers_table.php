<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_followed_providers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('followed_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('provider_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'provider_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('followed_providers');
    }
};
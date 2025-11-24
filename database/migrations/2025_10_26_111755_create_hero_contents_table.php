<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hero_contents', function (Blueprint $table) {
            $table->id();

            $table->string('title_part1');
            $table->string('title_part2');
            $table->text('description');

            // NEW fields based on model
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();

            $table->string('hero_alt_text')->nullable();
            $table->string('hero_image_thumbnail')->nullable();

            $table->integer('cleaners_count')->default(0);
            $table->decimal('rating', 3, 1)->default(0.0);

            $table->string('support_text')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_contents');
    }
};

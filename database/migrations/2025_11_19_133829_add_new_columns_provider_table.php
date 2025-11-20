<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            // Add the missing columns
            $table->text('ages_served_id')->nullable()->after('service_description');
            $table->text('operating_hours')->nullable()->after('ages_served_id');
            $table->string('care_types_id')->nullable()->after('operating_hours');
            $table->text('programs_offered_id')->nullable()->after('care_types_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn([
                'ages_served_id',
                'operating_hours',
                'care_types_id',
                'programs_offered_id'
            ]);
        });
    }
};
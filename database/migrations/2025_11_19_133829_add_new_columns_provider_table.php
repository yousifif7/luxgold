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
            $table->text('ages_served')->nullable()->after('service_description');
            $table->text('operating_hours')->nullable()->after('ages_served');
            $table->string('care_type')->nullable()->after('operating_hours');
            $table->text('programs_offered')->nullable()->after('care_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn([
                'ages_served',
                'operating_hours',
                'care_type',
                'programs_offered',
                'views',
                'clicks',
                'inquiries'
            ]);
        });
    }
};
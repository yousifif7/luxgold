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
        if (Schema::hasTable('cleaners')) {
            Schema::table('cleaners', function (Blueprint $table) {
                // Drop columns if they exist
                $cols = [
                    'business_name', 'contact_person', 'role_title',
                    'license_number', 'years_operation', 'insurance_coverage', 'diversity_badges', 'care_types_id'
                ];

                foreach ($cols as $col) {
                    if (Schema::hasColumn('cleaners', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        // Also remove from service_listings table if present
        if (Schema::hasTable('service_listings')) {
            Schema::table('service_listings', function (Blueprint $table) {
                if (Schema::hasColumn('service_listings', 'care_types_id')) {
                    $table->dropColumn('care_types_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cleaners')) {
            Schema::table('cleaners', function (Blueprint $table) {
                if (! Schema::hasColumn('cleaners', 'business_name')) {
                    $table->string('business_name')->nullable()->after('categories_id');
                }
                if (! Schema::hasColumn('cleaners', 'contact_person')) {
                    $table->string('contact_person')->nullable()->after('business_name');
                }
                if (! Schema::hasColumn('cleaners', 'role_title')) {
                    $table->string('role_title')->nullable()->after('contact_person');
                }
                if (! Schema::hasColumn('cleaners', 'license_number')) {
                    $table->string('license_number')->nullable()->after('availability_notes');
                }
                if (! Schema::hasColumn('cleaners', 'years_operation')) {
                    $table->string('years_operation')->nullable()->after('license_number');
                }
                if (! Schema::hasColumn('cleaners', 'insurance_coverage')) {
                    $table->string('insurance_coverage')->nullable()->after('years_operation');
                }
                if (! Schema::hasColumn('cleaners', 'diversity_badges')) {
                    $table->json('diversity_badges')->nullable()->after('insurance_coverage');
                }
                if (! Schema::hasColumn('cleaners', 'care_types_id')) {
                    $table->unsignedBigInteger('care_types_id')->nullable()->after('operating_hours');
                }
            });
        }

        if (Schema::hasTable('service_listings')) {
            Schema::table('service_listings', function (Blueprint $table) {
                if (! Schema::hasColumn('service_listings', 'care_types_id')) {
                    $table->unsignedBigInteger('care_types_id')->nullable()->after('operating_hours');
                }
            });
        }
    }
};

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
        if (Schema::hasTable('hire_requests')) {
            Schema::table('hire_requests', function (Blueprint $table) {
                if (! Schema::hasColumn('hire_requests', 'city')) {
                    $table->string('city')->nullable()->after('notes');
                }
                if (! Schema::hasColumn('hire_requests', 'zip_code')) {
                    $table->string('zip_code')->nullable()->after('city');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hire_requests')) {
            Schema::table('hire_requests', function (Blueprint $table) {
                if (Schema::hasColumn('hire_requests', 'zip_code')) {
                    $table->dropColumn('zip_code');
                }
                if (Schema::hasColumn('hire_requests', 'city')) {
                    $table->dropColumn('city');
                }
            });
        }
    }
};

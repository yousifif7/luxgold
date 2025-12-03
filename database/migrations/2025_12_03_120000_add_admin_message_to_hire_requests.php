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
        Schema::table('hire_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('hire_requests', 'admin_message')) {
                $table->text('admin_message')->nullable()->after('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hire_requests', function (Blueprint $table) {
            if (Schema::hasColumn('hire_requests', 'admin_message')) {
                $table->dropColumn('admin_message');
            }
        });
    }
};

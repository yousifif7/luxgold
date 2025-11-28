<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('hire_requests')) {
            Schema::table('hire_requests', function (Blueprint $table) {
                if (! Schema::hasColumn('hire_requests', 'cleaner_ids')) {
                    $table->json('cleaner_ids')->nullable()->after('cleaner_id');
                }
            });

            // Backfill existing cleaner_id values into cleaner_ids array
            $rows = DB::table('hire_requests')->select('id', 'cleaner_id')->get();
            foreach ($rows as $r) {
                if ($r->cleaner_id) {
                    DB::table('hire_requests')->where('id', $r->id)->update([
                        'cleaner_ids' => json_encode([$r->cleaner_id])
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hire_requests')) {
            Schema::table('hire_requests', function (Blueprint $table) {
                if (Schema::hasColumn('hire_requests', 'cleaner_ids')) {
                    $table->dropColumn('cleaner_ids');
                }
            });
        }
    }
};

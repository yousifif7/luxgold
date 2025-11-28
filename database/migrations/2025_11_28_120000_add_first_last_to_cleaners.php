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
        if (Schema::hasTable('cleaners')) {
            Schema::table('cleaners', function (Blueprint $table) {
                if (! Schema::hasColumn('cleaners', 'first_name')) {
                    $table->string('first_name')->nullable()->after('name');
                }
                if (! Schema::hasColumn('cleaners', 'last_name')) {
                    $table->string('last_name')->nullable()->after('first_name');
                }
            });

            // Backfill first_name/last_name from existing `name` value where possible
            $cleaners = DB::table('cleaners')->select('id', 'name')->get();
            foreach ($cleaners as $c) {
                if ($c->name) {
                    $parts = preg_split('/\\s+/', trim($c->name));
                    $first = $parts[0] ?? null;
                    $last = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : null;
                    DB::table('cleaners')->where('id', $c->id)->update([
                        'first_name' => $first,
                        'last_name' => $last,
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
        if (Schema::hasTable('cleaners')) {
            Schema::table('cleaners', function (Blueprint $table) {
                if (Schema::hasColumn('cleaners', 'last_name')) {
                    $table->dropColumn('last_name');
                }
                if (Schema::hasColumn('cleaners', 'first_name')) {
                    $table->dropColumn('first_name');
                }
            });
        }
    }
};

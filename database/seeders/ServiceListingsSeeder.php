<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceListingsSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('service_listings')) {
            return; // table missing, skip safely
        }

        // Find some cleaner ids to link listings
        $cleaners = DB::table('cleaners')->limit(5)->pluck('id')->toArray();

        if (empty($cleaners)) {
            return;
        }

        $now = now();

        $sample = [
            ['title' => 'Standard Home Cleaning', 'slug' => 'standard-home-cleaning', 'price' => 120.00, 'description' => '2-hour standard cleaning for a 2-bedroom home. Includes dusting, vacuuming, kitchen and bathroom cleaning.'],
            ['title' => 'Deep Clean - Move Out', 'slug' => 'deep-clean-move-out', 'price' => 280.00, 'description' => 'Full deep clean for move-out including baseboards, inside appliances, and detailed bathroom scrubbing.'],
            ['title' => 'Office Janitorial (Weekly)', 'slug' => 'office-janitorial-weekly', 'price' => 450.00, 'description' => 'Weekly janitorial service for small offices up to 1500 sqft.'],
        ];

        foreach ($sample as $i => $s) {
            $cleanerId = $cleaners[$i % count($cleaners)];

            DB::table('service_listings')->updateOrInsert(
                ['slug' => $s['slug'], 'cleaner_id' => $cleanerId],
                [
                    'cleaner_id' => $cleanerId,
                    'title' => $s['title'],
                    'slug' => $s['slug'],
                    'description' => $s['description'],
                    'price' => $s['price'],
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}

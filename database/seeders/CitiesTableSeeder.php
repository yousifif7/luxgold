<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class CitiesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        if (! Schema::hasTable('cities')) {
            $this->command->warn('Table `cities` does not exist, skipping CitiesTableSeeder.');
            return;
        }

        $cities = [
            ['name' => 'Austin', 'slug' => 'austin', 'cleaners_count' => 8],
            ['name' => 'Dallas', 'slug' => 'dallas', 'cleaners_count' => 6],
            ['name' => 'Houston', 'slug' => 'houston', 'cleaners_count' => 7],
            ['name' => 'San Antonio', 'slug' => 'san-antonio', 'cleaners_count' => 3],
        ];

        $useSlug = Schema::hasColumn('cities', 'slug');
        foreach ($cities as $city) {
            $key = $useSlug ? ['slug' => $city['slug']] : ['name' => $city['name']];

            // Prepare payload and ensure required columns exist with safe defaults
            $payload = $city;
            if (! $useSlug) {
                unset($payload['slug']);
            }

            if (! array_key_exists('icon_url', $payload)) {
                $payload['icon_url'] = '';
            }

            DB::table('cities')->updateOrInsert(
                $key,
                array_merge($payload, ['status' => true, 'created_at' => $now, 'updated_at' => $now])
            );
        }
    }
}

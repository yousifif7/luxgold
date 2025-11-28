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

        // Irish cities only
        $cities = [
            ['name' => 'Dublin', 'slug' => 'dublin', 'cleaners_count' => 0],
            ['name' => 'Cork', 'slug' => 'cork', 'cleaners_count' => 0],
            ['name' => 'Galway', 'slug' => 'galway', 'cleaners_count' => 0],
            ['name' => 'Limerick', 'slug' => 'limerick', 'cleaners_count' => 0],
            ['name' => 'Waterford', 'slug' => 'waterford', 'cleaners_count' => 0],
            ['name' => 'Drogheda', 'slug' => 'drogheda', 'cleaners_count' => 0],
            ['name' => 'Swords', 'slug' => 'swords', 'cleaners_count' => 0],
            ['name' => 'Dundalk', 'slug' => 'dundalk', 'cleaners_count' => 0],
            ['name' => 'Bray', 'slug' => 'bray', 'cleaners_count' => 0],
            ['name' => 'Ennis', 'slug' => 'ennis', 'cleaners_count' => 0],
            ['name' => 'Kilkenny', 'slug' => 'kilkenny', 'cleaners_count' => 0],
            ['name' => 'Tralee', 'slug' => 'tralee', 'cleaners_count' => 0],
            ['name' => 'Letterkenny', 'slug' => 'letterkenny', 'cleaners_count' => 0],
            ['name' => 'Naas', 'slug' => 'naas', 'cleaners_count' => 0],
            ['name' => 'Navan', 'slug' => 'navan', 'cleaners_count' => 0],
            ['name' => 'Mullingar', 'slug' => 'mullingar', 'cleaners_count' => 0],
            ['name' => 'Athlone', 'slug' => 'athlone', 'cleaners_count' => 0],
            ['name' => 'Newbridge', 'slug' => 'newbridge', 'cleaners_count' => 0],
            ['name' => 'Carlow', 'slug' => 'carlow', 'cleaners_count' => 0],
            ['name' => 'Wexford', 'slug' => 'wexford', 'cleaners_count' => 0],
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

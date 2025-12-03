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
            ['name' => 'Dublin', 'slug' => 'dublin', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/631401/pexels-photo-631401.jpeg'],
            ['name' => 'Cork', 'slug' => 'cork', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/34606665/pexels-photo-34606665.jpeg'],
            ['name' => 'Galway', 'slug' => 'galway', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/33943887/pexels-photo-33943887.jpeg'],
            ['name' => 'Limerick', 'slug' => 'limerick', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/33846155/pexels-photo-33846155.jpeg'],
            ['name' => 'Waterford', 'slug' => 'waterford', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/18617076/pexels-photo-18617076.jpeg'],
            ['name' => 'Drogheda', 'slug' => 'drogheda', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/3257895/pexels-photo-3257895.jpeg'],
            ['name' => 'Swords', 'slug' => 'swords', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/3972484/pexels-photo-3972484.jpeg'],
            ['name' => 'Dundalk', 'slug' => 'dundalk', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Bray', 'slug' => 'bray', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Ennis', 'slug' => 'ennis', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Kilkenny', 'slug' => 'kilkenny', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Tralee', 'slug' => 'tralee', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Letterkenny', 'slug' => 'letterkenny', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Naas', 'slug' => 'naas', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Navan', 'slug' => 'navan', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Mullingar', 'slug' => 'mullingar', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Athlone', 'slug' => 'athlone', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Newbridge', 'slug' => 'newbridge', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Carlow', 'slug' => 'carlow', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
            ['name' => 'Wexford', 'slug' => 'wexford', 'cleaners_count' => 0,'icon_url'=>'https://images.pexels.com/photos/730466/pexels-photo-730466.jpeg'],
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

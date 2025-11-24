<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        Event::create([
            'title'             => 'Prosper Christmas Festival',
            'subtitle'          => null,
            'description'       => 'The Prosper Christmas Festival is a beloved hometown tradition, a place to make holiday memories and celebrate the season.',
            'cleaner_name'     => null,
            'category'          => 'Festival',
            'location'          => 'Prosper Town Hall, 250 W. First St.',
            'city'              => 'Prosper',
            'start_date'        => '2025-12-06 15:00:00',   // based on “3-7 p.m.”
            'end_date'          => '2025-12-06 19:00:00',
            'cost'              => 0.00,                    // Free
            'status'            => 'active',
            'max_capacity'      => null,
            'current_capacity'  => 0,
            'age_group'         => null,
            'published_at'      => now(),
            'image_url'         => 'events/1.png',
            'author'            => 'System',
            'cleaner_id'       => 16,
        ]);
    }
}

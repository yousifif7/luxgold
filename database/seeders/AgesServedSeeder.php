<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class AgesServedSeeder extends Seeder
{
    public function run()
    {
        $ages = [
            [
                'title' => 'Infants (0-1)',
                'slug' => Str::slug('Infants 0-1'),
                'description' => 'Services for infants ages 0 to 1.',
            ],
            [
                'title' => 'Toddlers (1-3)',
                'slug' => Str::slug('Toddlers 1-3'),
                'description' => 'Programs designed for toddlers ages 1 to 3.',
            ],
            [
                'title' => 'Preschool (3-5)',
                'slug' => Str::slug('Preschool 3-5'),
                'description' => 'For preschool-age children between 3 and 5.',
            ],
            [
                'title' => 'Early Elementary (5-7)',
                'slug' => Str::slug('Early Elementary 5-7'),
                'description' => 'Early elementary learners aged 5 to 7.',
            ],
            [
                'title' => 'Elementary (7-10)',
                'slug' => Str::slug('Elementary 7-10'),
                'description' => 'Elementary school students ages 7 to 10.',
            ],
            [
                'title' => 'Pre-Teens (10-12)',
                'slug' => Str::slug('Pre-Teens 10-12'),
                'description' => 'Pre-teen learners between 10 and 12.',
            ],
            [
                'title' => 'Teens (13-17)',
                'slug' => Str::slug('Teens 13-17'),
                'description' => 'Teen students ages 13 to 17.',
            ],
            [
                'title' => 'Young Adults (18-21)',
                'slug' => Str::slug('Young Adults 18-21'),
                'description' => 'Students and learners between 18 and 21.',
            ],
            [
                'title' => 'Adults (21+)',
                'slug' => Str::slug('Adults 21+'),
                'description' => 'Adult learners ages 21 and above.',
            ],
            [
                'title' => 'All Ages',
                'slug' => Str::slug('All Ages'),
                'description' => 'Programs that serve all age groups.',
            ],
        ];

        DB::table('ages_served')->insert($ages);
    }
}

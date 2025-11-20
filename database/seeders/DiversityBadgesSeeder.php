<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class DiversityBadgesSeeder extends Seeder
{
    public function run()
    {
        $badges = [
            [
                'title' => 'Women Educators',
                'slug' => Str::slug('Women Educators'),
                'icon' => 'badges/women-educators.png',
                'description' => 'Educational content created or led by women educators.',
            ],
            [
                'title' => 'Minority Educators',
                'slug' => Str::slug('Minority Educators'),
                'icon' => 'badges/minority-educators.png',
                'description' => 'Courses designed or led by minority educators.',
            ],
            [
                'title' => 'Special Needs Friendly',
                'slug' => Str::slug('Special Needs Friendly'),
                'icon' => 'badges/special-needs-friendly.png',
                'description' => 'Accessible content suitable for special needs learners.',
            ],
            [
                'title' => 'Inclusive Curriculum',
                'slug' => Str::slug('Inclusive Curriculum'),
                'icon' => 'badges/inclusive-curriculum.png',
                'description' => 'Curriculum that includes diverse and inclusive material.',
            ],
            [
                'title' => 'LGBTQ+ Friendly',
                'slug' => Str::slug('LGBTQ+ Friendly'),
                'icon' => 'badges/lgbtq-friendly.png',
                'description' => 'Safe, respectful, and LGBTQ+ inclusive learning environment.',
            ],
            [
                'title' => 'Scholarship Available',
                'slug' => Str::slug('Scholarship Available'),
                'icon' => 'badges/scholarship-available.png',
                'description' => 'Programs offering partial or full scholarships.',
            ],
            [
                'title' => 'First-Gen Student Support',
                'slug' => Str::slug('First-Gen Student Support'),
                'icon' => 'badges/first-gen-support.png',
                'description' => 'Support programs specifically for first-generation students.',
            ],
            [
                'title' => 'International Friendly',
                'slug' => Str::slug('International Friendly'),
                'icon' => 'badges/international-friendly.png',
                'description' => 'Programs designed to support international students.',
            ],
        ];

        DB::table('diversity_badges')->insert($badges);
    }
}

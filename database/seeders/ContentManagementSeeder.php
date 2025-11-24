<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Resource;
use App\Models\HeroContent;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentManagementSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        City::truncate();
        HeroContent::truncate();
        Testimonial::truncate();
        Resource::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->createCities();
        $this->createHeroContent();
        $this->createTestimonials();
        $this->createResources();

        $this->command->info('Content management data seeded successfully!');
    }

    private function createCities()
    {
        $cities = [
            ['name' => 'Dallas', 'state' => 'TX', 'cleaners_count' => 156, 'families_count' => 2340, 'icon_url' => 'dummy.png', 'link' => '/dallas', 'is_coming_soon' => false, 'sort_order' => 1, 'status' => true],
            ['name' => 'Houston', 'state' => 'TX', 'cleaners_count' => 142, 'families_count' => 2180, 'icon_url' => 'dummy.png', 'link' => '/houston', 'is_coming_soon' => false, 'sort_order' => 2, 'status' => true],
            ['name' => 'Austin', 'state' => 'TX', 'cleaners_count' => 98, 'families_count' => 1670, 'icon_url' => 'dummy.png', 'link' => '/austin', 'is_coming_soon' => false, 'sort_order' => 3, 'status' => true],
            ['name' => 'San Antonio', 'state' => 'TX', 'cleaners_count' => 87, 'families_count' => 1540, 'icon_url' => 'dummy.png', 'link' => '/san-antonio', 'is_coming_soon' => false, 'sort_order' => 4, 'status' => true],
            ['name' => 'Fort Worth', 'state' => 'TX', 'cleaners_count' => 76, 'families_count' => 1320, 'icon_url' => 'dummy.png', 'link' => '/fort-worth', 'is_coming_soon' => false, 'sort_order' => 5, 'status' => true],
            ['name' => 'Plano', 'state' => 'TX', 'cleaners_count' => 54, 'families_count' => 980, 'icon_url' => 'dummy.png', 'link' => '/plano', 'is_coming_soon' => false, 'sort_order' => 6, 'status' => true],
            ['name' => 'San Diego', 'state' => 'CA', 'cleaners_count' => 0, 'families_count' => 0, 'icon_url' => 'dummy.png', 'link' => null, 'is_coming_soon' => true, 'sort_order' => 7, 'status' => true],
            ['name' => 'Phoenix', 'state' => 'AZ', 'cleaners_count' => 0, 'families_count' => 0, 'icon_url' => 'dummy.png', 'link' => null, 'is_coming_soon' => true, 'sort_order' => 8, 'status' => true],
        ];

        foreach ($cities as $city) {
            $city['icon_url'] = asset($city['icon_url']);
            City::create($city);
        }
    }

    private function createHeroContent()
    {
        HeroContent::create([
            'title_part1' => 'Your Home\'s',
            'title_part2' => 'trusted place for vetted cleaners and services',
            'description' => 'Find and compare professional cleaners nearby. Book recurring, deep and move-out cleans.',
            'cleaners_count' => 400,
            'rating' => 4.9,
            'support_text' => '24/7 Support',
            'status' => true,
        ]);
    }

    private function createTestimonials()
    {
        $testimonials = [
            ['name' => 'Sarah Johnson', 'location' => 'Dallas, TX', 'rating' => 5, 'content' => 'Sparkle cleaned our house spotless! Highly recommended.', 'avatar_url' => 'dummy.png', 'sort_order' => 1, 'status' => true],
            ['name' => 'Michael Chen', 'location' => 'Houston, TX', 'rating' => 5, 'content' => 'Great move-out cleaning service. Got my deposit back!', 'avatar_url' => 'dummy.png', 'sort_order' => 2, 'status' => true],
            ['name' => 'Emily Rodriguez', 'location' => 'Austin, TX', 'rating' => 5, 'content' => 'Quick booking and professional cleaners. Love the eco option.', 'avatar_url' => 'dummy.png', 'sort_order' => 3, 'status' => true],
        ];

        foreach ($testimonials as $t) {
            $t['avatar_url'] = asset($t['avatar_url']);
            Testimonial::create($t);
        }
    }

    private function createResources()
    {
        $resources = [
            ['title' => 'How to Prepare for a Cleaner Visit', 'description' => 'Tips to get the most from your first cleaning.', 'category' => 'Guides', 'image_url' => '', 'content' => '<p>Simple checklist to prepare.</p>', 'read_time' => '3 min read', 'slug' => 'prepare-for-cleaner', 'meta_title' => 'Prepare for Cleaner', 'meta_description' => 'Checklist to prepare for cleaner visits.', 'sort_order' => 1, 'status' => true],
            ['title' => 'Deep Cleaning vs Regular Cleaning', 'description' => 'When to choose a deep clean vs a recurring service.', 'category' => 'Guides', 'image_url' => '', 'content' => '<p>Differences explained.</p>', 'read_time' => '4 min read', 'slug' => 'deep-vs-regular', 'meta_title' => 'Deep vs Regular Cleaning', 'meta_description' => 'Understand services and pricing.', 'sort_order' => 2, 'status' => true],
        ];

        foreach ($resources as $r) {
            Resource::create($r);
        }
    }
}
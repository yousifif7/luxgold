<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('categories')) {
            $this->command->warn('Table `categories` does not exist, skipping CategoriesTableSeeder.');
            return;
        }

        $now = Carbon::now();

        // Focused set of cleaning-only categories (kept intentionally small)
        $categories = [
            [
                'name' => 'Home Cleaning',
                'slug' => 'home-cleaning',
                'subtitle' => 'Regular & Recurring Home Cleaning',
                'description' => 'Routine cleaning for homes: dusting, vacuuming, mopping and tidying.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-broom',
                'tags' => json_encode(['Recurring', 'Residential']),
                'image_url' => 'https://images.pexels.com/photos/4099260/pexels-photo-4099260.jpeg',
                'sort_order' => 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Deep Cleaning',
                'slug' => 'deep-cleaning',
                'subtitle' => 'Deep, One-time Cleans',
                'description' => 'Intensive deep cleans focused on kitchens, bathrooms and heavy soiling.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-sparkles',
                'tags' => json_encode(['Deep', 'One-time']),
                'image_url' => 'https://images.pexels.com/photos/4239007/pexels-photo-4239007.jpeg',
                'sort_order' => 2,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'End of Tenancy / Move Cleaning',
                'slug' => 'move-cleaning',
                'subtitle' => 'Move-out and Move-in Cleaning',
                'description' => 'Thorough cleaning for moving in or out of a property.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-box-open',
                'tags' => json_encode(['Move-out', 'Move-in']),
                'image_url' => 'https://images.pexels.com/photos/6873179/pexels-photo-6873179.jpeg',
                'sort_order' => 3,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Carpet & Upholstery Cleaning',
                'slug' => 'carpet-upholstery',
                'subtitle' => 'Carpet, Rugs and Upholstery',
                'description' => 'Professional carpet and upholstery cleaning for stains and odours.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-couch',
                'tags' => json_encode(['Carpet', 'Upholstery']),
                'image_url' => 'https://images.pexels.com/photos/4176226/pexels-photo-4176226.jpeg',
                'sort_order' => 4,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Window Cleaning',
                'slug' => 'window-cleaning',
                'subtitle' => 'Interior & Exterior Window Cleaning',
                'description' => 'Streak-free window and glass cleaning for homes and small businesses.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-window-maximize',
                'tags' => json_encode(['Windows', 'Glass']),
                'image_url' => 'https://images.pexels.com/photos/4239145/pexels-photo-4239145.jpeg',
                'sort_order' => 5,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Commercial Cleaning',
                'slug' => 'commercial-cleaning',
                'subtitle' => 'Offices & Commercial Spaces',
                'description' => 'Cleaning plans for offices, retail and other commercial spaces.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-building',
                'tags' => json_encode(['Office', 'Commercial']),
                'image_url' => 'https://images.pexels.com/photos/6197108/pexels-photo-6197108.jpeg',
                'sort_order' => 6,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $this->command->info('Categories seeded/updated successfully.');
    }
}
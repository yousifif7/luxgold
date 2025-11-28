<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesOfferdSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Kitchen Clean',
                'slug' => Str::slug('Kitchen Clean'),
                'icon' => 'services/kitchen.png',
                'description' => 'Cleaning of kitchen surfaces, countertops, and appliances.',
            ],
            [
                'title' => 'Bathroom Clean',
                'slug' => Str::slug('Bathroom Clean'),
                'icon' => 'services/bathroom.png',
                'description' => 'Deep cleaning of bathroom fixtures, tiles and grout.',
            ],
            [
                'title' => 'Living Room / Common Areas',
                'slug' => Str::slug('Living Room'),
                'icon' => 'services/living-room.png',
                'description' => 'Dusting, vacuuming and tidying of living areas.',
            ],
            [
                'title' => 'Oven Clean',
                'slug' => Str::slug('Oven Clean'),
                'icon' => 'services/oven.png',
                'description' => 'Specialist oven degreasing and interior cleaning.',
            ],
            [
                'title' => 'Sofa / Upholstery Clean',
                'slug' => Str::slug('Sofa Clean'),
                'icon' => 'services/sofa.png',
                'description' => 'Upholstery cleaning to remove stains and odours.',
            ],
            [
                'title' => 'Small Carpet Clean',
                'slug' => Str::slug('Small Carpet Clean'),
                'icon' => 'services/carpet-small.png',
                'description' => 'Cleaning of small rugs and carpets.',
            ],
            [
                'title' => 'Large Carpet Clean',
                'slug' => Str::slug('Large Carpet Clean'),
                'icon' => 'services/carpet-large.png',
                'description' => 'Deep cleaning for larger carpets and room-sized rugs.',
            ],
            [
                'title' => 'Window Interior Clean',
                'slug' => Str::slug('Window Interior Clean'),
                'icon' => 'services/window-interior.png',
                'description' => 'Interior window cleaning for streak-free glass.',
            ],
            [
                'title' => 'Window Exterior Clean',
                'slug' => Str::slug('Window Exterior Clean'),
                'icon' => 'services/window-exterior.png',
                'description' => 'Exterior window cleaning (reachable areas).',
            ],
            [
                'title' => 'Full Property Clean',
                'slug' => Str::slug('Full Property Clean'),
                'icon' => 'services/full-property.png',
                'description' => 'Comprehensive whole property clean (move/out tenancy).',
            ],
            [
                'title' => 'Office / Commercial Clean',
                'slug' => Str::slug('Office Commercial Clean'),
                'icon' => 'services/office.png',
                'description' => 'Commercial cleaning for offices and retail spaces.',
            ],
        ];

        foreach ($services as $s) {
            DB::table('services_offerd')->updateOrInsert(['slug' => $s['slug']], $s);
        }
    }
}

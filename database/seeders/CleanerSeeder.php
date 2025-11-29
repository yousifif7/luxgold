<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class CleanerSeeder extends Seeder
{
    public function run()
    {
        // Create a focused demo set of cleaners suitable for client demo.
        $cityNames = \App\Models\City::pluck('name')->toArray();
        if (empty($cityNames)) {
            $cityNames = ['Dublin','Cork','Galway','Limerick','Waterford','Drogheda','Swords','Dundalk'];
        }

        $demoCleaners = [
            [
                'name' => 'LuxGold Home Cleaners',
                'email' => 'hello@luxgold-cleaners.test',
                'phone' => '+353872001000',
                'description' => 'Experienced domestic cleaners offering weekly, fortnightly and deep cleans. Garda-vetted and insured.',
                'price' => 35.00,
                'featured' => true,
                'special_features' => ['Eco-friendly products','Pet-friendly'],
            ],
            [
                'name' => 'Emerald Sparkle',
                'email' => 'info@emeraldsparkle.test',
                'phone' => '+353872001001',
                'description' => 'End-of-lease and deep-clean specialists with oven and carpet options.',
                'price' => 80.00,
                'featured' => false,
                'special_features' => ['Oven cleaning','Carpet cleaning'],
            ],
            [
                'name' => 'Shamrock Shine',
                'email' => 'contact@shamrockshine.test',
                'phone' => '+353872001002',
                'description' => 'Reliable one-off cleans and reliable weekly teams. Fast turnaround for booking changes.',
                'price' => 45.00,
                'featured' => false,
                'special_features' => ['Same-week booking','Satisfaction guarantee'],
            ],
            [
                'name' => 'Sea Breeze Cleaners',
                'email' => 'service@seabreezecleaners.test',
                'phone' => '+353872001003',
                'description' => 'Specialists in coastal properties and holiday rental turnovers.',
                'price' => 50.00,
                'featured' => false,
                'special_features' => ['Holiday lets','Deep sea-salt removal'],
            ],
        ];

        $cleanerRole = Role::firstOrCreate(['name' => 'cleaner']);

        // Ensure there's at least one home-cleaning category
        $homeCategory = Category::firstOrCreate(['name' => 'Home Cleaning'], ['slug' => 'home-cleaning']);

        foreach ($demoCleaners as $i => $cdata) {
            $city = $cityNames[$i % count($cityNames)];
            $email = $cdata['email'];

            // Create or update user
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'first_name' => explode(' ', $cdata['name'])[0],
                    'last_name' => implode(' ', array_slice(explode(' ', $cdata['name']), 1)) ?: 'Cleaner',
                    'email' => $email,
                    'phone' => $cdata['phone'],
                    'city' => $city,
                    'state' => '',
                    'zip_code' => '',
                    'password' => bcrypt('password'),
                ]
            );

            if (! $user->hasRole('cleaner')) { $user->assignRole($cleanerRole); }

            Cleaner::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'name' => $cdata['name'],
                    'phone' => $cdata['phone'],
                    'email' => $email,
                    'physical_address' => $city,
                    'city' => $city,
                    'categories_id' => $homeCategory->id,
                    'sub_categories' => [],
                    'services_offerd' => [],
                    'service_description' => $cdata['description'],
                    'price_amount' => $cdata['price'] ?? 0,
                    'pricing_description' => 'Typical starting price per room',
                    'available_days' => ['monday','tuesday','wednesday','thursday','friday'],
                    'start_time' => '08:00:00',
                    'end_time' => '18:00:00',
                    'availability_notes' => 'Weekday availability, weekend on request',
                    'special_features' => $cdata['special_features'] ?? [],
                    'logo_path' => 'service-listings/logos/' . Str::slug($cdata['name']) . '.png',
                    'facility_photos_paths' => [],
                    'license_docs_paths' => [],
                    'status' => 'approved',
                    'is_featured' => $cdata['featured'] ? 1 : 0,
                ]
            );
        }
    }


}
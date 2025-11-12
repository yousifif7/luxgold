<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Provider;
use App\Models\Plan;
use App\Models\Subscription;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        if (!User::where('email', 'admin@gmail.com')->exists()) {
           $user = User::factory()->create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ]);

           $role = Role::where('name', 'admin')->first();
            $user->assignRole($role);
        }

        // Create Provider User with Complete Details
        if (!User::where('email','provider@gmail.com')->exists()) {
            $providerUser = User::factory()->create([
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'email' => 'provider@gmail.com',
                'phone' => '+1 (555) 123-4567',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62701',
                'search_radius' => 25,
                'password' => bcrypt('password'),
            ]);

            $role = Role::where('name', 'provider')->first();
            $providerUser->assignRole($role);

            // Create Provider Profile with All Details
            $provider = Provider::create([
                'user_id' => $providerUser->id,
                'name' => 'Sarah Johnson',
                'phone' => '+1 (555) 123-4567',
                'category' => 'Daycare Center',
                'business_name' => 'Sunshine Childcare Center',
                'contact_person' => 'Sarah Johnson',
                'role_title' => 'Owner/Director',
                'phone_number' => '+1 (555) 123-4567',
                'plans_id' => '2',
                'email' => 'sarah@sunshinechildcare.com',
                'physical_address' => '123 Maple Street, Springfield, IL 62701',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62701',
                'service_categories' => json_encode(['Early Learning & Care', 'Daycare Centers', 'Preschool Programs']),
                'service_description' => 'Sunshine Childcare Center provides a warm, nurturing environment for children ages 6 weeks to 12 years. Our experienced staff offers developmentally appropriate activities, nutritious meals, and a safe, stimulating environment. We believe in learning through play and provide a balanced curriculum that promotes social, emotional, and cognitive development.',
                'price_amount' => 180.00,
                'pricing_description' => 'Weekly rates include meals, educational activities, and extended hours',
                'available_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
                'start_time' => '07:00:00',
                'end_time' => '18:00:00',
                'availability_notes' => 'Extended hours available upon request. Part-time and drop-in care options available.',
                'license_number' => 'DC-IL-2024-001234',
                'years_operation' => 'Since 2018',
                'insurance_coverage' => 'Full liability insurance coverage up to $2,000,000',
                'diversity_badges' => json_encode(['women_owned', 'family_owned', 'inclusive', 'multicultural']),
                'special_features' => json_encode(['outdoor_playground', 'meals_included', 'educational_programs', 'security_cameras', 'transportation', 'summer_camps', 'arts_crafts']),
                'website' => 'https://www.sunshinechildcare-springfield.com',
                'facebook' => 'https://facebook.com/sunshinechildcarespringfield',
                'instagram' => 'https://instagram.com/sunshinechildcare_il',
                'logo_path' => 'dummy.png',
                'facility_photos_paths' => json_encode([
                    'dummy.png',
                    'dummy.png', 
                    'dummy.png',
                    'dummy.png'
                ]),
                'license_docs_paths' => json_encode(['dummy.png']),
                'status' => 'approved',
                'revenue' => 12500.00,
                'rating' => 4.8,
                'profile_views' => 2847,
                'views' => 5689,
                'clicks' => 342,
                'inquiries' => 89,
            ]);

            // Create subscription for provider
            $plan = Plan::where('type', 'Standard')->first();
            if ($plan) {
                Subscription::create([
                    'provider_id' => $provider->id,
                    'plan_id' => $plan->id,
                    'status' => 'active',
                    'amount' => $plan->monthly_fee,
                    'currency' => 'USD',
                    'started_at' => now()->subMonths(3),
                    'renews_at' => now()->addMonth(),
                    'is_active' => true,
                    'meta' => json_encode([
                        'auto_renew' => true,
                        'payment_method' => 'stripe'
                    ])
                ]);
            }
        }

        // Create Parent User
        if (!User::where('email','parent@gmail.com')->exists()) {
            $parentUser = User::factory()->create([
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'email' => 'parent@gmail.com',
                'phone' => '+1 (555) 987-6543',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62702',
                'search_radius' => 15,
                'notification_preferences' => json_encode([
                    'email_notifications' => true,
                    'push_notifications' => true,
                    'weekly_summary' => true,
                    'new_providers' => true
                ]),
                'password' => bcrypt('password'),
            ]);

            $role = Role::where('name', 'parent')->first();
            $parentUser->assignRole($role);
        }

        // Create Additional Test Parents
        $testParents = [
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael.johnson@example.com',
                'phone' => '+1 (555) 234-5678',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62703',
            ],
            [
                'first_name' => 'Jessica',
                'last_name' => 'Williams',
                'email' => 'jessica.williams@example.com',
                'phone' => '+1 (555) 345-6789',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62701',
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Miller',
                'email' => 'david.miller@example.com',
                'phone' => '+1 (555) 456-7890',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62704',
            ]
        ];

        foreach ($testParents as $parentData) {
            if (!User::where('email', $parentData['email'])->exists()) {
                $parentUser = User::factory()->create(array_merge($parentData, [
                    'search_radius' => rand(10, 30),
                    'notification_preferences' => json_encode([
                        'email_notifications' => true,
                        'push_notifications' => rand(0, 1),
                        'weekly_summary' => rand(0, 1),
                        'new_providers' => true
                    ]),
                    'password' => bcrypt('password'),
                ]));

                $role = Role::where('name', 'parent')->first();
                $parentUser->assignRole($role);
            }
        }

        // Create Additional Test Providers
        $testProviders = [
            [
                'business_name' => 'Little Explorers Preschool',
                'category' => 'Preschool',
                'contact_person' => 'Maria Garcia',
                'email' => 'info@littleexplorers.com',
                'phone' => '+1 (555) 567-8901',
                'physical_address' => '456 Oak Avenue, Springfield, IL 62702',
                'city' => 'Springfield',
                'state' => 'IL',
                'service_description' => 'Little Explorers Preschool offers a play-based curriculum for children ages 3-5. Our focus is on developing social skills, creativity, and early literacy through hands-on activities and exploration.',
                'price_amount' => 220.00,
                'special_features' => ['montessori_approach', 'outdoor_classroom', 'music_program', 'spanish_lessons'],
            ],
            [
                'business_name' => 'Happy Kids After School',
                'category' => 'After-school Program',
                'contact_person' => 'Robert Chen',
                'email' => 'contact@happykidsafterschool.com',
                'phone' => '+1 (555) 678-9012',
                'physical_address' => '789 Pine Street, Springfield, IL 62703',
                'city' => 'Springfield',
                'state' => 'IL',
                'service_description' => 'Happy Kids provides a safe and engaging after-school environment for elementary school children. We offer homework help, enrichment activities, and recreational programs.',
                'price_amount' => 150.00,
                'special_features' => ['homework_help', 'stem_activities', 'sports_programs', 'transportation'],
            ],
            [
                'business_name' => 'Creative Minds Tutoring',
                'category' => 'Tutoring',
                'contact_person' => 'Dr. Amanda Roberts',
                'email' => 'admin@creativemindstutoring.com',
                'phone' => '+1 (555) 789-0123',
                'physical_address' => '321 Elm Street, Springfield, IL 62701',
                'city' => 'Springfield',
                'state' => 'IL',
                'service_description' => 'Professional tutoring services for K-12 students in all subjects. Our certified teachers provide personalized learning plans and academic support.',
                'price_amount' => 45.00,
                'special_features' => ['certified_teachers', 'test_prep', 'online_options', 'homework_support'],
            ]
        ];

        foreach ($testProviders as $providerData) {
            if (!User::where('email', $providerData['email'])->exists()) {
                $providerUser = User::factory()->create([
                    'first_name' => explode(' ', $providerData['contact_person'])[0],
                    'last_name' => explode(' ', $providerData['contact_person'])[1] ?? 'Provider',
                    'email' => $providerData['email'],
                    'phone' => $providerData['phone'],
                    'city' => $providerData['city'],
                    'state' => $providerData['state'],
                    'password' => bcrypt('password'),
                ]);

                $role = Role::where('name', 'provider')->first();
                $providerUser->assignRole($role);

                $provider = Provider::create([
                    'user_id' => $providerUser->id,
                    'name' => $providerData['contact_person'],
                    'phone' => $providerData['phone'],
                    'category' => $providerData['category'],
                    'business_name' => $providerData['business_name'],
                    'contact_person' => $providerData['contact_person'],
                    'role_title' => 'Director',
                    'phone_number' => $providerData['phone'],
                    'plans_id' => rand(1, 2),
                    'email' => $providerData['email'],
                    'physical_address' => $providerData['physical_address'],
                    'city' => $providerData['city'],
                    'state' => $providerData['state'],
                    'zip_code' => '6270' . rand(1, 4),
                    'service_categories' => json_encode([$providerData['category']]),
                    'service_description' => $providerData['service_description'],
                    'price_amount' => $providerData['price_amount'],
                    'pricing_description' => 'Various packages and discounts available',
                    'available_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']),
                    'start_time' => rand(6, 9) . ':00:00',
                    'end_time' => rand(17, 20) . ':00:00',
                    'is_featured'=>1,
                    'license_number' => 'LIC-' . strtoupper(substr($providerData['category'], 0, 3)) . '-2024-' . rand(1000, 9999),
                    'years_operation' => 'Since ' . rand(2015, 2022),
                    'diversity_badges' => json_encode([['women_owned', 'family_owned', 'inclusive'][rand(0, 2)]]),
                    'special_features' => json_encode($providerData['special_features']),
                    'logo_path' => 'dummy.png',
                    'facility_photos_paths' => json_encode(['dummy.png', 'dummy.png']),
                    'status' => 'approved',
                    'revenue' => rand(5000, 20000),
                    'rating' => round(rand(35, 50) / 10, 1),
                    'profile_views' => rand(500, 3000),
                    'views' => rand(1000, 6000),
                    'clicks' => rand(50, 400),
                    'inquiries' => rand(20, 150),
                ]);

                // Create subscription
                $plan = Plan::inRandomOrder()->first();
                if ($plan) {
                    Subscription::create([
                        'provider_id' => $provider->id,
                        'plan_id' => $plan->id,
                        'status' => 'active',
                        'amount' => $plan->monthly_fee,
                        'currency' => 'USD',
                        'started_at' => now()->subMonths(rand(1, 12)),
                        'renews_at' => now()->addMonths(rand(1, 3)),
                        'is_active' => true,
                    ]);
                }
            }
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: admin@supremesecurity.co.uk / password');
        $this->command->info('Provider: provider@askroro.test / password');
        $this->command->info('Parent: parent@askroro.test / password');
    }
}
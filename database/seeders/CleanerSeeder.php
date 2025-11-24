<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cleaner;
use App\Models\Category;
use App\Models\CareType;
use App\Models\ProgramsOffered;
use App\Models\AgesServed;
use App\Models\Plan;
use App\Models\Subscription;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class CleanerSeeder extends Seeder
{
    public function run()
    {
        $examples = [
            [
                'name' => 'Sparkle Home Cleaning',
                'business_name' => 'Sparkle Home Cleaning LLC',
                'description' => 'Professional recurring and deep cleaning for homes and apartments.',
                'phone' => '555-0101',
                'location' => 'Dallas, TX',
                'email' => 'sparkle@example.com',
            ],
            [
                'name' => 'Bright & Clean Services',
                'business_name' => 'Bright & Clean Services',
                'description' => 'Move-in/out and one-time deep cleans done by vetted professionals.',
                'phone' => '555-0102',
                'location' => 'Plano, TX',
                'email' => 'brightclean@example.com',
            ],
            [
                'name' => 'Neighborhood Maids',
                'business_name' => 'Neighborhood Maids LLC',
                'description' => 'Eco-friendly residential cleaning with optional add-on services.',
                'phone' => '555-0103',
                'location' => 'Frisco, TX',
                'email' => 'maids@example.com',
            ],
        ];

        $cleanerRole = Role::firstOrCreate(['name' => 'cleaner']);

        foreach ($examples as $i => $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => explode(' ', $data['name'])[0],
                    'last_name' => implode(' ', array_slice(explode(' ', $data['name']), 1)),
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'city' => explode(',', $data['location'])[0],
                    'state' => trim(explode(',', $data['location'])[1] ?? ''),
                    'password' => bcrypt('password'),
                ]
            );

            if (!$user->hasRole('cleaner')) {
                $user->assignRole($cleanerRole);
            }

            Cleaner::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'name' => $data['name'],
                    'business_name' => $data['business_name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'physical_address' => $data['location'],
                    'service_description' => $data['description'],
                    'status' => 'approved',
                ]
            );
}

$cleaners = [
    [
        'name' => 'KinderCare - Prosper',
                'business_name' => 'KinderCare Learning Center',
                'description' => 'NAEYC-accredited KinderCare serving ages 6 weeks–12 years with full/part-time, before-after-school and vacation programs; play-based curriculum fostering exploration, literacy, creativity.',
                'ages_served' => '6 weeks - 12 yrs',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:00 PM',
                'phone' => '972-347-1234',
                'care_type' => 'Private',
                'programs_offered' => 'Education',
                'email' => 'prosper@kindercare.com',
                'category' => 'Education & Tutoring',
            ],
            [
                'name' => 'Founders Classical Academy',
                'business_name' => 'Founders Classical Academy',
                'description' => 'Founders Classical Academy seeks to provide an excellent and distinctively classical education that pursues knowledge, promotes virtue, and prepares students for prosperous lives in a free Society.',
                'ages_served' => '5 Yrs - 18 yrs',
                'location' => 'Prosper',
                'hours' => '7:50 AM - 3:15 PM',
                'phone' => '469-382-9669',
                'care_type' => 'Charter',
                'programs_offered' => 'Education',
                'email' => 'info@foundersclassical.org',
                'category' => 'Education & Tutoring',
            ],
            [

                'location' => 'Prosper',
                'hours' => '3:00 PM - 8:00 PM',
                'phone' => '469-296-8195',
                'care_type' => 'Private',
                'programs_offered' => 'Sports & Athletics',
                'email' => 'info@problackbeltacademy.com',
                'category' => 'After-School Programs',
            ],
            [
                'name' => 'Eagle Wings Athletics',
                'business_name' => 'Eagle Wings Athletics',
                'description' => 'Let Eagle\'s Wings Athletics Gymnastics After School come to your rescue. Your child will be safely transported from their school to Eagle\'s Wings for gymnastics training.',
                'ages_served' => '3 Yrs+',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 8:00 PM',
                'phone' => '972-347-5540',
                'care_type' => 'Private',
                'programs_offered' => 'Sports & Athletics',
                'email' => 'info@eaglewingsathletics.com',
                'category' => 'After-School Programs',
            ],
            [
                'name' => 'A Joyful Mess',
                'business_name' => 'A Joyful Mess Art Studio',
                'description' => 'A Joyful Mess is a children\'s art studio where we are inspiring creativity and joy in our community through the power of art! Offering after school classes, workshops, summer camps, preschool Mommy & Me play groups, homeschool art classes, birthday parties and more.',
                'ages_served' => '1 Yr+ - teen',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 6:00 PM',
                'phone' => '972-963-9662',
                'care_type' => 'Private',
                'programs_offered' => 'Performing Arts',
                'email' => 'info@ajoyfulmess.com',
                'category' => 'After-School Programs',
            ],

            // Wellness & Development
            [
                'name' => 'UWAT Unconditional Wellness & Athletic Therapy',
                'business_name' => 'UWAT Wellness Center',
                'description' => 'Holistic wellness services including massage and bodywork therapies',
                'ages_served' => '13+',
                'location' => 'Prosper',
                'hours' => '8:00 AM - 6:00 PM',
                'phone' => '469-428-3488',
                'care_type' => 'Holistic Health',
                'programs_offered' => 'Massage and Bodywork',
                'email' => 'info@uwellness.com',
                'category' => 'Wellness & Development',
            ],
            [
                'name' => 'Telos SPINE AND SPORT',
                'business_name' => 'Telos Spine and Sport',
                'description' => 'Chiropractic Care, Shockwave Therapy, Tendonitis treatment and more',
                'ages_served' => 'All ages',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 5:00 PM',
                'phone' => '469-214-9973',
                'care_type' => 'Medical',
                'programs_offered' => 'Chiropractic Care',
                'email' => 'info@telossport.com',
                'category' => 'Wellness & Development',
            ],
            [
                'name' => 'Core Strength Wellness Center',
                'business_name' => 'Core Strength Wellness Center',
                'description' => 'Chiropractic Care, Family Chiropractic, Sport Chiropractic, Back Pain, Knee Pain, Spine Care etc.',
                'ages_served' => 'All ages',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 5:00 PM',
                'phone' => '972-292-9863',
                'care_type' => 'Medical',
                'programs_offered' => 'Chiropractic Care',
                'email' => 'info@corestrengthwellness.com',
                'category' => 'Wellness & Development',
            ],
            [
                'name' => 'Autism Response Team',
                'business_name' => 'Autism Response Team',
                'description' => 'Specialized ABA therapy services for children with autism',
                'ages_served' => '2-18 years',
                'location' => 'Prosper',
                'hours' => '8:00 AM - 4:00 PM',
                'phone' => '469-780-4897',
                'care_type' => 'Medical',
                'programs_offered' => 'ABA Therapy',
                'email' => 'info@autismresponseteam.com',
                'category' => 'Wellness & Development',
            ],
            [
                'name' => 'Made Well Counselling and Wellness',
                'business_name' => 'Made Well Counselling and Wellness',
                'description' => 'Comprehensive therapy services for individuals and families',
                'ages_served' => '13+ & women',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 5:00 PM',
                'phone' => '469-498-4567',
                'care_type' => 'Mental Health',
                'programs_offered' => 'Therapy',
                'email' => 'info@madewellcounseling.com',
                'category' => 'Wellness & Development',
            ],
            [
                'name' => 'NIDANA Wellness',
                'business_name' => 'NIDANA Wellness Center',
                'description' => 'Diagnostics, Detox Coaching, Comprehensive BioAnalysis Diagnostic, Red Light Therapy, Frequency Therapy, Functional & Foundational Medicine',
                'ages_served' => '18+',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 6:00 PM',
                'phone' => '972-409-6233',
                'care_type' => 'Holistic Health',
                'programs_offered' => 'Wellness Services',
                'email' => 'info@nidanawellness.com',
                'category' => 'Wellness & Development',
            ],

            // Sports, Fitness & Recreation
            [
                'name' => 'Pro Black Belt Academy - Sports',
                'business_name' => 'Pro Black Belt Academy',
                'description' => 'At Professional Black Belt Academy, we are proud to provide an after school program that packs a punch! Our team of professional instructors provides martial arts lessons that will help your child stay focused, active, and healthy.',
                'ages_served' => '3yrs+',
                'location' => 'Prosper',
                'hours' => '3:00 PM - 8:00 PM',
                'phone' => '469-296-8195',
                'care_type' => 'Private',
                'programs_offered' => 'Martial Arts',
                'email' => 'sports@problackbeltacademy.com',
                'category' => 'Sports, Fitness & Recreation',
            ],
            [
                'name' => 'Eagle Wings Athletics - Sports',
                'business_name' => 'Eagle Wings Athletics',
                'description' => 'Our gymnastics class levels are designed to cater to the unique needs and abilities of each age group. Join us today and watch your child thrive doing something they love.',
                'ages_served' => '3yrs+',
                'location' => 'Prosper',
                'hours' => '9:00 AM - 8:00 PM',
                'phone' => '972-347-5540',
                'care_type' => 'Private',
                'programs_offered' => 'Gymnastics',
                'email' => 'sports@eaglewingsathletics.com',
                'category' => 'Sports, Fitness & Recreation',
            ],
            [
                'name' => 'Prosper Elite Basketball',
                'business_name' => 'Prosper Elite Basketball Academy',
                'description' => 'Building Basketball Excellence with Passion and Purpose',
                'ages_served' => '5 yrs -18 Yrs',
                'location' => 'Prosper',
                'hours' => '5:00 PM - 10:00 PM',
                'phone' => '972-565-3774',
                'care_type' => 'Private',
                'programs_offered' => 'Basketball Training',
                'email' => 'info@prosperelitebasketball.com',
                'category' => 'Sports, Fitness & Recreation',
            ],
            [
                'name' => 'Kids Strong',
                'business_name' => 'Kids Strong Training Center',
                'description' => 'KidStrong is a kids training program that builds strong, confident and high-character kids.',
                'ages_served' => '2-11yrs',
                'location' => 'Prosper',
                'hours' => '8:00 AM - 3:00 PM',
                'phone' => '469-498-4567',
                'care_type' => 'Private',
                'programs_offered' => 'Strength Training',
                'email' => 'info@kidsstrong.com',
                'category' => 'Sports, Fitness & Recreation',
            ],
            [
                'name' => 'RockStar Martial Arts',
                'business_name' => 'RockStar Martial Arts',
                'description' => 'Brazilian Jiu Jitsu and Kids Martial Arts Training at Rockstar Martial Arts',
                'ages_served' => '3.5yrs+',
                'location' => 'Prosper',
                'hours' => '4:00 PM - 8:00 PM',
                'phone' => '972-800-3478',
                'care_type' => 'Private',
                'programs_offered' => 'Martial Arts',
                'email' => 'info@rockstarmartialarts.com',
                'category' => 'Sports, Fitness & Recreation',
            ],
        ];

        foreach ($cleaners as $index => $cleanerData) {
            $email = "cleaner" . ($index + 1) . "@gmail.com";
            
            if (!User::where('email', $email)->exists()) {
                $fullName = $cleanerData['name'] ?? ('Cleaner ' . ($index + 1));
                $cleanerUser = User::factory()->create([
                    'first_name' => explode(' ', $fullName)[0],
                    'last_name' => implode(' ', array_slice(explode(' ', $fullName), 1)),
                    'email' => $email,
                    'phone' => $cleanerData['phone'] ?? null,
                    'city' => 'Prosper',
                    'state' => 'TX',
                    'zip_code' => '75078',
                    'search_radius' => 25,
                    'password' => bcrypt('password'),
                ]);

                $role = Role::where('name', 'cleaner')->first();
                $cleanerUser->assignRole($role);

                // Basic validation and safe defaults for optional keys
                $name = $cleanerData['name'] ?? null;
                if (! $name) {
                    // Skip entries without a name — they are likely leftover/invalid
                    continue;
                }

                $categoryName = $cleanerData['category'] ?? 'General';
                $careTypeName = $cleanerData['care_type'] ?? 'General';
                $programsOfferedName = $cleanerData['programs_offered'] ?? 'General';
                $agesServedTitle = $cleanerData['ages_served'] ?? null;

                // Determine subcategory based on category and care type
                $subcategory = $this->getSubcategory($categoryName, $careTypeName, $programsOfferedName);

                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    ['slug' => Str::slug($categoryName)]
                );

                $care_type = CareType::firstOrCreate(
                    ['name' => $careTypeName],
                    ['slug' => Str::slug($careTypeName)]
                );

                $programs_offered = ProgramsOffered::firstOrCreate(
                    ['name' => $programsOfferedName],
                    ['slug' => Str::slug($programsOfferedName)]
                );

                $ages_served = null;
                if ($agesServedTitle) {
                    $ages_served = AgesServed::firstOrCreate(
                        ['title' => $agesServedTitle],
                        ['slug' => Str::slug($agesServedTitle)]
                    );
                }

                // Create cleaner Profile
                $cleaner = Cleaner::create([
                    'user_id' => $cleanerUser->id,
                    'name' => $name,
                    'phone' => $cleanerData['phone'] ?? '',
                    'categories_id' => $category->id,
                    'business_name' => $cleanerData['business_name'] ?? '',
                    'contact_person' => $name,
                    'role_title' => 'Director',
                    'phone_number' => $cleanerData['phone'] ?? '',
                    'plans_id' => '2',
                    'email' => $cleanerData['email'] ?? $email,
                    'physical_address' => ($cleanerData['location'] ?? '') . ', TX',
                    'city' => 2,
                    'state' => 'TX',
                    'zip_code' => '75078',
                    'sub_categories' => [],
                    'service_description' => $cleanerData['description'] ?? '',
                    'ages_served_id' => $ages_served ? $ages_served->id : null,
                    'operating_hours' => $cleanerData['hours'] ?? '',
                    'care_types_id' => $care_type->id,
                    'programs_offered_id' => $programs_offered->id,
                    'price_amount' => 0,
                    'pricing_description' => '',
                    'available_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'start_time' => '07:00:00',
                    'end_time' => '18:00:00',
                    'availability_notes' => $cleanerData['hours'] ?? '',
                    'license_number' => '',
                    'years_operation' => '',
                    'insurance_coverage' => '',
                    'diversity_badges' => [],
                    'special_features' => [],
                    'website' => '',
                    'facebook' => '',
                    'instagram' => '',
                    'logo_path' => 'service-listings/logos/'.strtolower(str_replace(' ', '_', $name)) . '.png',
                    'facility_photos_paths' => [],
                    'license_docs_paths' => [],
                    'status' => 'approved',
                ]);

                // Create subscription for provider
                $plan = Plan::where('type', 'Standard')->first();
                if ($plan) {
                    Subscription::create([
                        'cleaner_id' => $cleaner->id,
                        'plan_id' => $plan->id,
                        'status' => 'active',
                        'amount' => $plan->monthly_fee,
                        'currency' => 'USD',
                        'started_at' => now()->subMonths(rand(1, 12)),
                        'renews_at' => now()->addMonth(),
                        'is_active' => true,
                        'meta' => json_encode([
                            'auto_renew' => true,
                            'payment_method' => 'stripe'
                        ])
                    ]);
                }
            }
        }
    }

    /**
     * Get subcategory based on category and care type
     */
    private function getSubcategory($category, $careType, $programsOffered)
    {
        switch ($category) {
            case 'Childcare & Early Learning':
                if ($careType === 'Montessori') {
                    return 'Montessori';
                } elseif ($careType === 'Faith-Based') {
                    return 'Daycare / Preschool';
                } else {
                    return 'Daycare / Preschool';
                }

            case 'Education & Tutoring':
                if (str_contains(strtolower($programsOffered), 'tutoring')) {
                    return 'Tutoring';
                } else {
                    return 'Education';
                }

            case 'After-School Programs':
                if (str_contains(strtolower($programsOffered), 'sports') || str_contains(strtolower($programsOffered), 'athletics')) {
                    return 'Sports & Athletics';
                } elseif (str_contains(strtolower($programsOffered), 'arts')) {
                    return 'Performing Arts';
                } else {
                    return 'General After-School Care';
                }

            case 'Wellness & Development':
                if (str_contains(strtolower($careType), 'holistic')) {
                    return 'Holistic Health & Wellness';
                } elseif (str_contains(strtolower($careType), 'medical')) {
                    return 'Medical & Behavioral Health Clinics';
                } else {
                    return 'Wellness Services';
                }

            case 'Sports, Fitness & Recreation':
                if (str_contains(strtolower($programsOffered), 'martial') || str_contains(strtolower($programsOffered), 'jiu jitsu')) {
                    return 'Martial Arts';
                } elseif (str_contains(strtolower($programsOffered), 'gymnastics')) {
                    return 'Gymnastics';
                } elseif (str_contains(strtolower($programsOffered), 'basketball')) {
                    return 'Basketball';
                } else {
                    return 'Sports & Recreation';
                }

            default:
                return 'General';
        }
    }
}
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

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            // Childcare & Early Learning (Original providers)
            [
                'name' => 'Christian Learning Center - North Campus',
                'business_name' => 'Christian Learning Center - North Campus',
                'description' => 'Teaching Children to Love Christ, Learning, Relationship',
                'ages_served' => '8 weeks - 5yrs',
                'location' => 'Prosper',
                'hours' => '9:00 a.m. to 2:00 p.m.',
                'phone' => '972-798-6740',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'info@christianlearningcenter.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Primerose School - Prosper',
                'business_name' => 'Primerose School - Prosper',
                'description' => 'Providing families with a top-tier private preschool experience focused on early learning, child development, and a caring foundation for future success.',
                'ages_served' => '6 weeks - 4yrs',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '(972) 787-9971',
                'care_type' => 'Private',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'prosper@primeroseschool.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Grace Chapel Early Learning Center',
                'business_name' => 'Grace Chapel Early Learning Center',
                'description' => 'Grace Chapel Early Learning Center offers a nurturing Christian environment where children receive both quality care and faith-based education to support their early growth and development.',
                'ages_served' => '18 Mth - 4yrs 11 Mth',
                'location' => 'Prosper',
                'hours' => '9:05 AM - 4:00 PM',
                'phone' => '940.440.6626',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'info@gracechapellearning.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'THE GODDARD SCHOOL',
                'business_name' => 'THE GODDARD SCHOOL',
                'description' => 'The Goddard School provides a play-based learning environment focused on early childhood development and enrichment. Afterschool programs extend the day with structured activities, homework help, and social engagement in a safe, nurturing setting.',
                'ages_served' => '6 weeks – 5 years',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '972-472-1177',
                'care_type' => 'Private',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'prosper@goddardschool.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Amazing Explorer Academy',
                'business_name' => 'Amazing Explorer Academy',
                'description' => 'Amazing Explorers Academy fosters a nurturing environment where little minds open up to develop lifelong learning skills designed to inspire, connect and engage the great minds of the 21st century.',
                'ages_served' => '6 weeks – 5 yrs old',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '(469) 296-8180',
                'care_type' => 'Private',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'info@amazingexploreracademy.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Maya Montessori',
                'business_name' => 'Maya Montessori',
                'description' => 'At Maya Montessori, we believe exceptional care is about more than just routines—it\'s about connection, trust, and purpose-driven learning. Here\'s what truly sets us apart.',
                'ages_served' => '2yrs - 5 yrs',
                'location' => 'Prosper',
                'hours' => '7:00 AM - 6:00 PM',
                'phone' => '460.661.4765',
                'care_type' => 'Montessori',
                'programs_offered' => 'Childcare+Preschool',
                'email' => 'info@mayamontessori.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'The Children\'s Courtyard of Prosper',
                'business_name' => 'The Children\'s Courtyard of Prosper',
                'description' => 'A warm and welcoming place where kids can learn, play, and grow! We offer programs for infants through school-age children, with a balance of fun activities and learning experiences that build confidence, creativity, and friendships',
                'ages_served' => '6 Weeks - 5 Years',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '972.619.4275',
                'care_type' => 'Private',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'prosper@childrenscourtyard.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Premier Christian Academy - Prosper',
                'business_name' => 'Premier Christian Academy - Prosper',
                'description' => 'Offering Preschool, Early Education, & More Featuring the Abeka Curriculum',
                'ages_served' => '6 weeks - 4yrs',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '972.734035',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'info@premierchristianacademy.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Ivy Kids Learning Center',
                'business_name' => 'Ivy Kids Learning Center',
                'description' => 'we create warm, secure environments where children feel safe, learn with joy, and build confidence for kindergarten and beyond.',
                'ages_served' => '3 to 5 Years',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '+1 (972) 347-9103',
                'care_type' => 'Private',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'info@ivykidslearning.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Kids R Kids',
                'business_name' => 'Kids R Kids',
                'description' => 'The Kids \'R\' Kids Infant Program has been carefully designed to deliver a safe, nurturing and stimulating environment with activities to help your child achieve important milestones while having fun!',
                'ages_served' => '6 weeks - 4yrs',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '4692961500',
                'care_type' => 'Private',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'prosper@kidsrkids.com',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Prosper United Methodist Pre-School (PUMP)',
                'business_name' => 'Prosper United Methodist Pre-School (PUMP)',
                'description' => 'The purpose of PUMP is to build a strong, Christian foundation of love and learning in every child through nurturing and challenging them appropriately in all developmental areas.',
                'ages_served' => 'newborn - 4yrs',
                'location' => 'Prosper',
                'hours' => '8:30am-2:30pm',
                'phone' => '972-347-2372',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'Childcare-PreK',
                'email' => 'info@prosperump.org',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Saint Paul\'s Episcopal Preschool',
                'business_name' => 'Saint Paul\'s Episcopal Preschool',
                'description' => 'SPES\'s mission is to grow children spiritually, intellectually, socially, and physically by equipping them with the Gospel, a love of learning, a creative mind, a strong body, and a giving spirit.',
                'ages_served' => '2yrs -4yrs',
                'location' => 'Prosper',
                'hours' => '',
                'phone' => '972.347.9700',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'Childcare+Preschool',
                'email' => 'preschool@stpaulsprosper.org',
                'category' => 'Childcare & Early Learning',
            ],
            [
                'name' => 'Whispering Farms Montessori Academy',
                'business_name' => 'Whispering Farms Montessori Academy',
                'description' => 'Nurturing young minds through the proven Montessori method in a peaceful, nature-inspired environment.',
                'ages_served' => '6 weeks - 6yrs',
                'location' => 'Prosper',
                'hours' => '7:00 AM - 6:00 PM',
                'phone' => '(972) 346-3200',
                'care_type' => 'Montessori',
                'programs_offered' => 'Kindergarten',
                'email' => 'info@whisperingfarmsmontessori.com',
                'category' => 'Childcare & Early Learning',
            ],

            // School Age Education & Tutoring
            [
                'name' => 'Prosper ISD',
                'business_name' => 'Prosper Independent School District',
                'description' => 'Prosper Independent School District (PISD) in North Texas is one of the fastest-growing districts, serving over 32,000 students across Collin and Denton counties. It includes 20 elementary schools, 6 middle schools, and 4 high school.',
                'ages_served' => '5 Yrs - 18 yrs',
                'location' => 'Prosper',
                'hours' => '7:50 AM - 4:15 PM',
                'phone' => '945-678-0000',
                'care_type' => 'Public',
                'programs_offered' => 'Education',
                'email' => 'info@prosper-isd.org',
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'PRESTONWOOD CHRISTIAN ACADEMY - North',
                'business_name' => 'PRESTONWOOD CHRISTIAN ACADEMY',
                'description' => 'PCA partners with Christian parents to equip students to stand firmly in biblical truth, pursue academic excellence, and develop Christ-like leadership that impacts their homes, churches, and communities',
                'ages_served' => '5 Yrs - 18 yrs',
                'location' => 'Prosper',
                'hours' => '8:00 AM - 3:15 PM',
                'phone' => '972-798-6780',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'Education',
                'email' => 'info@prestonwoodchristian.org',
                'category' => 'School Age Education & Tutoring',
            ],
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
                'category' => 'School Age Education & Tutoring',
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
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'Children\'s Lighthouse',
                'business_name' => 'Children\'s Lighthouse Learning Center',
                'description' => 'Children\'s Lighthouse leads the way in values-based early childhood education - providing care for infants, toddlers, preschoolers, and school-age children.',
                'ages_served' => '6 weeks – 12 years',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '945-295-9566',
                'care_type' => 'Private',
                'programs_offered' => 'Education',
                'email' => 'prosper@childrenslighthouse.com',
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'Kiddie Academy',
                'business_name' => 'Kiddie Academy of Prosper',
                'description' => 'Kiddie Academy provides educational child care designed to nurture curiosity, confidence, and a lifelong love of learning',
                'ages_served' => '6 weeks – 12 years',
                'location' => 'Prosper',
                'hours' => '6:30 AM - 6:30 PM',
                'phone' => '469-715-9020',
                'care_type' => 'Private',
                'programs_offered' => 'Education',
                'email' => 'prosper@kiddieacademy.com',
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'Sylvan Learning - Prosper',
                'business_name' => 'Sylvan Learning Center',
                'description' => 'Sylvan is Your Bridge to Back-to-School Readiness',
                'ages_served' => '5yrs - 18yrs',
                'location' => 'Prosper',
                'hours' => '12:30 PM - 7:30 PM',
                'phone' => '469-817-9972',
                'care_type' => 'Private',
                'programs_offered' => 'Tutoring',
                'email' => 'prosper@sylvanlearning.com',
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'Best Brains Learning Center - Prosper',
                'business_name' => 'Best Brains Learning Center',
                'description' => 'Best Brains is an after-school Tutoring & Enrichment program, designed to enhance your child\'s overall academic development. Board-certified teachers work with your child on a weekly basis in a fun-filled interactive learning environment.',
                'ages_served' => '3 Yrs - 18 yrs',
                'location' => 'Prosper',
                'hours' => '4:30 PM - 7:30 PM',
                'phone' => '469-527-0000',
                'care_type' => 'Private',
                'programs_offered' => 'Tutoring',
                'email' => 'prosper@bestbrains.com',
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'Kumon',
                'business_name' => 'Kumon Math & Reading Center',
                'description' => 'Build Confidence in School with the Kumon Math & Reading Program. Every Practice Counts. Because Every Skill Matters',
                'ages_served' => '3 Yrs - 13+',
                'location' => 'Prosper',
                'hours' => '3:00 PM - 7:00 PM',
                'phone' => '469-715-2500',
                'care_type' => 'Private',
                'programs_offered' => 'Tutoring',
                'email' => 'prosper@kumon.com',
                'category' => 'School Age Education & Tutoring',
            ],
            [
                'name' => 'Mathnasium - The Math Learning Center',
                'business_name' => 'Mathnasium',
                'description' => 'Mathnasium\'s programs help K-12 students at any skill level build solid foundations for math mastery, while transforming how they think and feel about math.',
                'ages_served' => '5yrs - 18yrs',
                'location' => 'Prosper',
                'hours' => '4:30 PM - 7:30 PM',
                'phone' => '972-347-3322',
                'care_type' => 'Private',
                'programs_offered' => 'Tutoring',
                'email' => 'prosper@mathnasium.com',
                'category' => 'School Age Education & Tutoring',
            ],

            // AfterSchool Program
            [
                'name' => 'Premier Christian Academy - After School',
                'business_name' => 'Premier Christian Academy',
                'description' => 'Offering Preschool, Early Education, & More Featuring the Abeka Curriculum',
                'ages_served' => '5 -12 Yrs',
                'location' => 'Prosper',
                'hours' => '3:00 PM - 6:00 PM',
                'phone' => '972-734-035',
                'care_type' => 'Faith-Based',
                'programs_offered' => 'General After-School Care',
                'email' => 'afterschool@premierchristianacademy.com',
                'category' => 'AfterSchool Program',
            ],
            [
                'name' => 'Kids R Kids - After School',
                'business_name' => 'Kids R Kids After School Program',
                'description' => 'The Kids \'R\' Kids Infant Program has been carefully designed to deliver a safe, nurturing and stimulating environment with activities to help your child achieve important milestones while having fun!',
                'ages_served' => '5yrs - 11 yrs',
                'location' => 'Prosper',
                'hours' => '3:00 PM - 6:30 PM',
                'phone' => '469-296-1500',
                'care_type' => 'Private',
                'programs_offered' => 'General After-School Care',
                'email' => 'afterschool@kidsrkids.com',
                'category' => 'AfterSchool Program',
            ],
            [
                'name' => 'Pro Black Belt Academy',
                'business_name' => 'Pro Black Belt Academy',
                'description' => 'Experience The Top Choice for Martial Arts And Karate In Prosper',
                'ages_served' => '3yrs+',
                'location' => 'Prosper',
                'hours' => '3:00 PM - 8:00 PM',
                'phone' => '469-296-8195',
                'care_type' => 'Private',
                'programs_offered' => 'Sports & Athletics',
                'email' => 'info@problackbeltacademy.com',
                'category' => 'AfterSchool Program',
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
                'category' => 'AfterSchool Program',
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
                'category' => 'AfterSchool Program',
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

        foreach ($providers as $index => $providerData) {
            $email = "provider" . ($index + 1) . "@gmail.com";
            
            if (!User::where('email', $email)->exists()) {
                $providerUser = User::factory()->create([
                    'first_name' => explode(' ', $providerData['name'])[0],
                    'last_name' => implode(' ', array_slice(explode(' ', $providerData['name']), 1)),
                    'email' => $email,
                    'phone' => $providerData['phone'],
                    'city' => 'Prosper',
                    'state' => 'TX',
                    'zip_code' => '75078',
                    'search_radius' => 25,
                    'password' => bcrypt('password'),
                ]);

                $role = Role::where('name', 'provider')->first();
                $providerUser->assignRole($role);

                // Determine subcategory based on category and care type
                $subcategory = $this->getSubcategory($providerData['category'], $providerData['care_type'], $providerData['programs_offered']);

                // Create Provider Profile
                $provider = Provider::create([
                    'user_id' => $providerUser->id,
                    'name' => $providerData['name'],
                    'phone' => $providerData['phone'],
                    'category' => $providerData['category'],
                    'business_name' => $providerData['business_name'],
                    'contact_person' => $providerData['name'],
                    'role_title' => 'Director',
                    'phone_number' => $providerData['phone'],
                    'plans_id' => '2',
                    'email' => $providerData['email'],
                    'physical_address' => $providerData['location'] . ', TX',
                    'city' => 'Prosper',
                    'state' => 'TX',
                    'zip_code' => '75078',
                    'service_categories' => json_encode([$providerData['category'], $subcategory]),
                    'service_description' => $providerData['description'],
                    'ages_served' => $providerData['ages_served'],
                    'operating_hours' => $providerData['hours'],
                    'care_type' => $providerData['care_type'],
                    'programs_offered' => $providerData['programs_offered'],
                    'price_amount' => null,
                    'pricing_description' => '',
                    'available_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday']),
                    'start_time' => '07:00:00',
                    'end_time' => '18:00:00',
                    'availability_notes' => $providerData['hours'],
                    'license_number' => '',
                    'years_operation' => '',
                    'insurance_coverage' => '',
                    'diversity_badges' => json_encode([]),
                    'special_features' => json_encode([]),
                    'website' => '',
                    'facebook' => '',
                    'instagram' => '',
                    'logo_path' => 'service-listings/logos/'.strtolower(str_replace(' ', '_', $providerData['name'])) . '.png',
                    'facility_photos_paths' => json_encode([]),
                    'license_docs_paths' => json_encode([]),
                    'status' => 'approved',
                    'revenue' => rand(8000, 20000),
                    'rating' => round(rand(40, 50) / 10, 1),
                    'profile_views' => rand(1000, 5000),
                    'views' => rand(2000, 8000),
                    'clicks' => rand(200, 600),
                    'inquiries' => rand(50, 150),
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

            case 'School Age Education & Tutoring':
                if (str_contains(strtolower($programsOffered), 'tutoring')) {
                    return 'Tutoring';
                } else {
                    return 'Education';
                }

            case 'AfterSchool Program':
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
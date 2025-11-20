<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class SpecialFeaturesSeeder extends Seeder
{
    public function run()
    {
        $features = [
            [
                'title' => '24/7 Support',
                'slug' => Str::slug('24/7 Support'),
                'icon' => 'features/support.png',
                'description' => 'Learners can get support anytime they need.',
            ],
            [
                'title' => 'Practice Tests Included',
                'slug' => Str::slug('Practice Tests Included'),
                'icon' => 'features/practice-tests.png',
                'description' => 'Includes mock exams and practice test materials.',
            ],
            [
                'title' => 'Certificate Provided',
                'slug' => Str::slug('Certificate Provided'),
                'icon' => 'features/certificate.png',
                'description' => 'Students receive a certificate upon completion.',
            ],
            [
                'title' => 'Installment Plans Available',
                'slug' => Str::slug('Installment Plans Available'),
                'icon' => 'features/installments.png',
                'description' => 'Flexible payment plans for students.',
            ],
            [
                'title' => 'Internship Opportunities',
                'slug' => Str::slug('Internship Opportunities'),
                'icon' => 'features/internship.png',
                'description' => 'Courses that offer internship placements.',
            ],
            [
                'title' => 'Live Classes',
                'slug' => Str::slug('Live Classes'),
                'icon' => 'features/live-classes.png',
                'description' => 'Real-time classes with instructors.',
            ],
            [
                'title' => 'Downloadable Resources',
                'slug' => Str::slug('Downloadable Resources'),
                'icon' => 'features/downloadable.png',
                'description' => 'Includes PDFs, notes, and learning resources.',
            ],
            [
                'title' => 'Job Placement Support',
                'slug' => Str::slug('Job Placement Support'),
                'icon' => 'features/job-support.png',
                'description' => 'Programs with career guidance and job support.',
            ],
        ];

        DB::table('special_features')->insert($features);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class ServicesOfferdSeeder extends Seeder
{
    public function run()
    {
        $services = [

    // --- YOUR EXISTING ITEMS ABOVE THIS ---

    [
        'title' => 'Childcare – PreK',
        'slug' => Str::slug('Childcare PreK'),
        'icon' => 'services/childcare-prek.png',
        'description' => 'Pre-kindergarten childcare services.',
    ],
    [
        'title' => 'Childcare + Preschool',
        'slug' => Str::slug('Childcare Preschool'),
        'icon' => 'services/childcare-preschool.png',
        'description' => 'Combined childcare and preschool learning.',
    ],
    [
        'title' => 'Kindergarten',
        'slug' => Str::slug('Kindergarten'),
        'icon' => 'services/kindergarten.png',
        'description' => 'Kindergarten education services.',
    ],
    [
        'title' => 'Maths, English, Coding, Abacus, Test Prep',
        'slug' => Str::slug('Maths English Coding Abacus Test Prep'),
        'icon' => 'services/academic-multi.png',
        'description' => 'Academic tutoring across multiple subjects.',
    ],
    [
        'title' => 'General After-School Care',
        'slug' => Str::slug('General After-School Care'),
        'icon' => 'services/after-school.png',
        'description' => 'General after-school supervision and learning.',
    ],
    [
        'title' => 'Sports & Athletics',
        'slug' => Str::slug('Sports Athletics'),
        'icon' => 'services/sports-athletics.png',
        'description' => 'Sports, physical training, and athletics programs.',
    ],
    [
        'title' => 'Sports & Recreation',
        'slug' => Str::slug('Sports Recreation'),
        'icon' => 'services/sports-recreation.png',
        'description' => 'Recreation and sports activities for youth.',
    ],
    [
        'title' => 'Performing Arts (Music, Dance, Theater)',
        'slug' => Str::slug('Performing Arts Music Dance Theater'),
        'icon' => 'services/performing-arts.png',
        'description' => 'Training in music, dance, and theater.',
    ],
    [
        'title' => 'Massage and Bodywork',
        'slug' => Str::slug('Massage and Bodywork'),
        'icon' => 'services/massage-bodywork.png',
        'description' => 'Massage therapy and bodywork services.',
    ],
    [
        'title' => 'Chiropractic Care & Shockwave Therapy',
        'slug' => Str::slug('Chiropractic Care Shockwave Therapy'),
        'icon' => 'services/chiropractic-shockwave.png',
        'description' => 'Chiropractic treatments including shockwave therapy and tendonitis care.',
    ],
    [
        'title' => 'Chiropractic Care & Spine Wellness',
        'slug' => Str::slug('Chiropractic Care Spine Wellness'),
        'icon' => 'services/chiropractic-spine.png',
        'description' => 'Family and sports chiropractic including spine, knee, and back care.',
    ],
    [
        'title' => 'ABA Therapy',
        'slug' => Str::slug('ABA Therapy'),
        'icon' => 'services/aba-therapy.png',
        'description' => 'Applied Behavior Analysis therapy services.',
    ],
    [
        'title' => 'Therapy',
        'slug' => Str::slug('Therapy'),
        'icon' => 'services/therapy.png',
        'description' => 'General therapy and wellness services.',
    ],
    [
        'title' => 'Diagnostics',
        'slug' => Str::slug('Diagnostics'),
        'icon' => 'services/diagnostics.png',
        'description' => 'Diagnostics and clinical testing services.',
    ],
    [
        'title' => 'Detox Coaching',
        'slug' => Str::slug('Detox Coaching'),
        'icon' => 'services/detox-coaching.png',
        'description' => 'Detox and health optimization coaching.',
    ],
    [
        'title' => 'Comprehensive BioAnalysis Diagnostic',
        'slug' => Str::slug('Comprehensive BioAnalysis Diagnostic'),
        'icon' => 'services/bioanalysis.png',
        'description' => 'Full-body diagnostic and bioanalysis services.',
    ],
    [
        'title' => 'Red Light Therapy (Full Body)',
        'slug' => Str::slug('Red Light Therapy Full Body'),
        'icon' => 'services/red-light.png',
        'description' => 'Full-body red light therapy sessions.',
    ],
    [
        'title' => 'Frequency Therapy',
        'slug' => Str::slug('Frequency Therapy'),
        'icon' => 'services/frequency-therapy.png',
        'description' => 'Energy-based frequency therapy services.',
    ],
    [
        'title' => 'Functional & Foundational Medicine',
        'slug' => Str::slug('Functional Foundational Medicine'),
        'icon' => 'services/functional-medicine.png',
        'description' => 'Holistic functional and foundational medical services.',
    ],

];


        DB::table('services_offerd')->insert($services);
    }
}

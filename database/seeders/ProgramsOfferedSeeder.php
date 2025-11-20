<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramsOfferedSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            'Childcare-PreK',
            'Childcare+Preschool',
            'Kindergarten',
            'Education',
            'Tutoring',
            'General After-School Care',
            'Sports & Athletics',
            'Performing Arts',
            'Massage and Bodywork',
            'Chiropractic Care',
            'ABA Therapy',
            'Therapy',
            'Wellness Services',
            'Martial Arts',
            'Gymnastics',
            'Basketball Training',
            'Strength Training',
        ];

        foreach ($programs as $program) {
            DB::table('programs_offered')->insert([
                'name' => $program,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

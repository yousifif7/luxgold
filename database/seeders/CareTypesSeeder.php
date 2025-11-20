<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Faith-Based',
            'Private',
            'Montessori',
            'Public',
            'Charter',
            'Holistic Health',
            'Medical',
            'Mental Health',
        ];

        foreach ($types as $type) {
            DB::table('care_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

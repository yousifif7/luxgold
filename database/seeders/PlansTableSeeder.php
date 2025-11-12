<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PlansTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('plans')->insert([
            [
                'id' => 1,
                'name' => 'Basic',
                'type' => 'Basic',
                'monthly_fee' => 10.00,
                'annual_fee' => 100.00,
                'description' => 'Basic',
                'features' => json_encode([
                    "Business Name, Address, Contact Info" => "1",
                    "Update Basic Profile Info" => "1",
                    "Appear in Comparison Tool" => "1",
                    "Save & Share Parent Leads" => "1",
                    "Verified Provider Badge" => "1",
                    "“Trusted Choice” Badge" => "1"
                ]),
                'is_active' => 1,
                'created_at' => Carbon::parse('2025-10-26 04:07:13'),
                'updated_at' => Carbon::parse('2025-10-26 04:07:13'),
            ],
            [
                'id' => 2,
                'name' => 'Standard',
                'type' => 'Standard',
                'monthly_fee' => 20.00,
                'annual_fee' => 200.00,
                'description' => 'Basic',
                'features' => json_encode([
                    "Business Name, Address, Contact Info" => "1",
                    "Update Basic Profile Info" => "1",
                    "Appear in Comparison Tool" => "1",
                    "Save & Share Parent Leads" => "1",
                    "Verified Provider Badge" => "1",
                    "“Trusted Choice” Badge" => "1"
                ]),
                'is_active' => 1,
                'created_at' => Carbon::parse('2025-10-26 04:07:13'),
                'updated_at' => Carbon::parse('2025-10-26 04:07:13'),
            ]
        ]);
    }
}

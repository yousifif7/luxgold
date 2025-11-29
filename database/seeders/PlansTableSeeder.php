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
                'description' => 'Basic listing for cleaners: profile, contact and search visibility.',
                'features' => json_encode([
                    "Profile Listing (name, contact, address)" => "1",
                    "Edit Basic Profile" => "1",
                    "Appear In Search Results" => "1",
                    "Receive Leads (contact details)" => "1",
                    "Verified Cleaner Badge" => "0",
                    "Featured Listing" => "0"
                ]),
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Standard',
                'type' => 'Standard',
                'monthly_fee' => 25.00,
                'annual_fee' => 250.00,
                'description' => 'Standard plan: adds featured placement and priority support for cleaners.',
                'features' => json_encode([
                    "Profile Listing (name, contact, address)" => "1",
                    "Edit Full Profile" => "1",
                    "Appear In Search Results" => "1",
                    "Receive Leads (contact details)" => "1",
                    "Verified Cleaner Badge" => "1",
                    "Featured Listing" => "1",
                    "Priority Support" => "1"
                ]),
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

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

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: admin@supremesecurity.co.uk / password');
        $this->command->info('Parent: parent@askroro.test / password');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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

       
        // Create a default customer (formerly 'parent')
        if (! User::where('email', 'customer@example.com')->exists()) {
            $customer = User::factory()->create([
                'first_name' => 'Customer',
                'last_name' => 'User',
                'email' => 'customer@example.com',
                'phone' => '+1 (555) 000-0001',
                'city' => 'Springfield',
                'state' => 'IL',
                'zip_code' => '62701',
                'password' => bcrypt('password'),
            ]);

            $role = Role::where('name', 'customer')->first();
            if ($role) { $customer->assignRole($role); }
        }

        // Create a few sample cleaners (users with cleaner role)
        $sampleCleaners = [
            ['first_name' => 'Laura', 'last_name' => 'Green', 'email' => 'laura.cleaner@example.com', 'phone' => '+1 (555) 111-0001', 'city' => 'Austin', 'state' => 'TX'],
            ['first_name' => 'Carlos', 'last_name' => 'Martinez', 'email' => 'carlos.cleaner@example.com', 'phone' => '+1 (555) 222-0002', 'city' => 'Dallas', 'state' => 'TX'],
            ['first_name' => 'Aisha', 'last_name' => 'Khan', 'email' => 'aisha.cleaner@example.com', 'phone' => '+1 (555) 333-0003', 'city' => 'Houston', 'state' => 'TX'],
        ];

        foreach ($sampleCleaners as $c) {
            if (! User::where('email', $c['email'])->exists()) {
                $user = User::factory()->create(array_merge($c, [
                    'password' => bcrypt('password'),
                ]));

                $role = Role::where('name', 'cleaner')->first();
                if ($role) { $user->assignRole($role); }
            }
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Admin: admin@supremesecurity.co.uk / password');
        $this->command->info('Customer: customer@askroro.test / password');
    }
}
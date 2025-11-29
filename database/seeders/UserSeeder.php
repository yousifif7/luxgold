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

       
        // Create a default customer (Irish demo)
        if (! User::where('email', 'customer@luxgold.test')->exists()) {
            $customer = User::factory()->create([
                'first_name' => 'Customer',
                'last_name' => 'User',
                'email' => 'customer@luxgold.test',
                'phone' => '+353 87 000 0001',
                'city' => 'Dublin',
                'state' => '',
                'zip_code' => '',
                'password' => bcrypt('password'),
            ]);

            $role = Role::where('name', 'customer')->first();
            if ($role) { $customer->assignRole($role); }
        }

        // Create a few sample cleaners (Irish cities)
        $sampleCleaners = [
            ['first_name' => 'Aoife', 'last_name' => 'Murphy', 'email' => 'aoife.murphy@luxgold.test', 'phone' => '+353 87 111 0001', 'city' => 'Dublin'],
            ['first_name' => 'Sean', 'last_name' => "O'Brien", 'email' => 'sean.obrien@luxgold.test', 'phone' => '+353 87 222 0002', 'city' => 'Cork'],
            ['first_name' => 'Ciara', 'last_name' => 'Walsh', 'email' => 'ciara.walsh@luxgold.test', 'phone' => '+353 87 333 0003', 'city' => 'Galway'],
            ['first_name' => 'Liam', 'last_name' => "O'Sullivan", 'email' => 'liam.osullivan@luxgold.test', 'phone' => '+353 87 444 0004', 'city' => 'Limerick'],
            ['first_name' => 'Niamh', 'last_name' => 'Kelly', 'email' => 'niamh.kelly@luxgold.test', 'phone' => '+353 87 555 0005', 'city' => 'Waterford'],
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
        $this->command->info('Admin: admin@gmail.com / password');
        $this->command->info('Customer: customer@luxgold.test / password');
    }
}
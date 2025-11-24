<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AgesServedSeeder::class,
            DiversityBadgesSeeder::class,
            ServicesOfferdSeeder::class,
            SpecialFeaturesSeeder::class,
            ProgramsOfferedSeeder::class,
            CareTypesSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PlansTableSeeder::class,
            CategoriesTableSeeder::class,
            CitiesTableSeeder::class,
            CleanerSeeder::class,
            ServiceListingsSeeder::class,
            ContentManagementSeeder::class,
            EventSeeder::class,
        ]);
    }
}

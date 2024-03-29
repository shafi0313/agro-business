<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            // RESettingsSeeder::class,
            // AdnanSettingsSeeder::class,
            SeontageSettingsSeeder::class,
            PackSizeSeeder::class,
            // BankListSeeder::class,
            EmployeeMainCatSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'Developer',
            'email' => 'admin@shafi95.com',
            'role' => 1,
            'is' => 1,
            'phone' => 1725848515,
            'address' => 'Hatboalia, Alamdanga, Chuadaga',
            'password' => bcrypt('##Zxc1234'),
        ];
        User::insert($user);
    }
}

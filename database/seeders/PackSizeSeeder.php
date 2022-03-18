<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\PackSize;
use Illuminate\Database\Seeder;

class PackSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $packSize = [
            ['type' => 1, 'size' => '1 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '2 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '10 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '20 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '50 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '100 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '500 gm', 'created_at' => $now],
            ['type' => 1, 'size' => '1 kg', 'created_at' => $now],
            ['type' => 1, 'size' => '5 kg', 'created_at' => $now],
            ['type' => 1, 'size' => '10 kg', 'created_at' => $now],
            ['type' => 1, 'size' => '20 kg', 'created_at' => $now],
            ['type' => 1, 'size' => '25 kg', 'created_at' => $now],
            ['type' => 1, 'size' => '40 kg', 'created_at' => $now],
            ['type' => 1, 'size' => '100 ml', 'created_at' => $now],
            ['type' => 1, 'size' => '250 ml', 'created_at' => $now],
            ['type' => 1, 'size' => '400 ml', 'created_at' => $now],
            ['type' => 1, 'size' => '5 L', 'created_at' => $now],
            ['type' => 1, 'size' => '20 L', 'created_at' => $now],

            ['type' => 2, 'size' => '25 kg', 'created_at' => $now],
            ['type' => 2, 'size' => '40 kg', 'created_at' => $now],
            ['type' => 2, 'size' => '50 kg', 'created_at' => $now],
            ['type' => 2, 'size' => '20 L', 'created_at' => $now],
            ['type' => 2, 'size' => '200 L', 'created_at' => $now],
        ];
        PackSize::insert($packSize);
    }
}

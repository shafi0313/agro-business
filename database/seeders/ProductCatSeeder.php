<?php

namespace Database\Seeders;

use App\Models\ProductCat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $productCats = [
            ['name' => 'Insecticide (কীটনাশক)', 'created_at' => $now],
            ['name' => 'Fungicide (ছত্রাকনাশক)', 'created_at' => $now],
            ['name' => 'Herbicide (আগাছানাশক)', 'created_at' => $now],
            ['name' => 'Yield Booster (ফলন বর্ধক)', 'created_at' => $now],
            ['name' => 'Fertilizer (সার)', 'created_at' => $now],
        ];
        ProductCat::insert($productCats);
    }
}

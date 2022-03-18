<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\BankList;
use Illuminate\Database\Seeder;

class BankListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $bankList = [
            [
                'name' => 'Pubali Bank Limited',
                'created_at' => $now,
            ],
            [
                'name' => 'Islami Bank Bangladesh Ltd.',
                'created_at' => $now,
            ]
        ];
        BankList::insert($bankList);
    }
}

<?php

namespace Database\Seeders;

use App\Models\EmployeeMainCat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeMainCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $employeeMainCat = [
            ['name' => 'CA (Chief Advisor)', 'created_at' => $now],
            ['name' => 'Chairman', 'created_at' => $now],
            ['name' => 'CEO (Chief Executive Officer)', 'created_at' => $now],
            ['name' => 'COO(Chief Operating Officer)', 'created_at' => $now],
            ['name' => 'Advisors', 'created_at' => $now],
            ['name' => 'CFO(Chief Financial Officer)', 'created_at' => $now],
            ['name' => 'Chief Admin Officer', 'created_at' => $now],
            ['name' => 'Office Manager', 'created_at' => $now],
            ['name' => 'Ass. Office Manager', 'created_at' => $now],
            ['name' => 'Chief Marketing Manager', 'created_at' => $now],
            ['name' => 'Zonal Sales Manager', 'created_at' => $now],
            ['name' => 'Senior Sales Officer', 'created_at' => $now],
            ['name' => 'Sales Officer', 'created_at' => $now],
            ['name' => 'B. Consultant', 'created_at' => $now],
            ['name' => 'Factory Manager', 'created_at' => $now],
            ['name' => 'Repacking Staff', 'created_at' => $now],
            ['name' => 'Account Assistant', 'created_at' => $now],
        ];
        EmployeeMainCat::insert($employeeMainCat);
    }
}


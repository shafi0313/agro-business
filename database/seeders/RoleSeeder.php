<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [ 'name' => 'admin' ],
            [ 'name' => 'editor' ],
            [ 'name' => 'viewer' ],
        ];
        foreach ($roles as &$role) {
            $role['guard_name'] = 'web';
        }

        \Spatie\Permission\Models\Role::insert($roles);
    }
}

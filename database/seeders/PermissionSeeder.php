<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [ 'name' => 'admin' ],
            [ 'name' => 'editor' ],
            [ 'name' => 'viewer' ],
        ];
        foreach ($permissions as &$permission) {
            $permission['guard_name'] = 'web';
        }

        \Spatie\Permission\Models\Permission::insert($permissions);
    }
}

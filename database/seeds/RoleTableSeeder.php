<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            ['role_id' => 1, 'role_rolename' => 'admin', 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            ['role_id' => 2, 'role_rolename' => 'lecteur', 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            ['role_id' => 3, 'role_rolename' => 'superadmin', 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
        ];

        Role::insert($roles);

    }
}

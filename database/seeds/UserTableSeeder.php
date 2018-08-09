<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['id' => 1, 'fk_role_id' => 3, 'name' => 'Sophie Quehen', 'email' => 'sophie.quehen@gmail.com', 'password' => bcrypt('secret'), 'remember_token' => NULL, 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'fk_role_id' => 3, 'name' => 'Romaric Defrance', 'email' => 'romaric@calyxen.com', 'password' => bcrypt('secret'), 'remember_token' => NULL, 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 3, 'fk_role_id' => 1, 'name' => 'Nico Fer', 'email' => 'nico.ferreira.web@gmail.com', 'password' => bcrypt('secret'), 'remember_token' => NULL, 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 4, 'fk_role_id' => 1, 'name' => 'Arthur Epineau', 'email' => 'arthurepi64@gmail.com', 'password' => bcrypt('secret'), 'remember_token' => NULL, 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 5, 'fk_role_id' => 2, 'name' => 'Kris Tell', 'email' => 'christellelocque@hotmail.fr', 'password' => bcrypt('secret'), 'remember_token' => NULL, 'created_at' => date('Y-m-d H:i:s'),  'updated_at' => date('Y-m-d H:i:s')],
            
        ];

        User::insert($users);
    }
}
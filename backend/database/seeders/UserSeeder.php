<?php

namespace Database\Seeders;

use App\Helpers\PasswordHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwordSalt = PasswordHelper::getPasswordSalt();

        $users = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'username' => 'admin',
                'password' => PasswordHelper::getHashPassword('123456', $passwordSalt),
                'password_salt' => $passwordSalt,
            ],
        ];

        DB::table('users')->insert($users);
    }
}

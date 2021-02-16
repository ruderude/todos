<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'テスト太郎',
                'email' => 'test@test.com',
                'password' => Hash::make('11111111'),
            ],

        ]);
    }
}

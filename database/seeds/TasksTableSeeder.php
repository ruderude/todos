<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            [
                'user_id' => 1,
                'name' => 'タスク1',
                'details' => 'xxxxxxxxx',
                'done' => false,
            ],
            [
                'user_id' => 1,
                'name' => 'タスク2',
                'details' => 'xxxxxxxxx',
                'done' => true,
            ],
            [
                'user_id' => 1,
                'name' => 'タスク3',
                'details' => 'xxxxxxxxx',
                'done' => false,
            ],

        ]);
    }
}

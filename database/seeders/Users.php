<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Users extends Seeder
{
    const DEFAULT_USERS = [
        [
            'name' => 'Микола Кобак',
            'email' => 'metalhead0710@gmail.com',
            'password' => '',
        ],
        [
            'name' => 'Віталік Єганов',
            'email' => 'vitekyeganov@gmail.com',
            'password' => '',
        ],
        [
            'name' => 'Ромко Мойсеюк',
            'email' => 'blitztelegram@gmail.com',
            'password' => '',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(static::DEFAULT_USERS);
    }
}

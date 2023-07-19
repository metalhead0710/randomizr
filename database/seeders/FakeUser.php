<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FakeUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\FakeUser::factory(9568)->create();
    }
}

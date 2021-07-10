<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Songs extends Seeder
{
    const DEFAULT_SONGS = [
        [
            'author' => 'Брати Гадюкіни',
            'name' => 'Було б не любити',
            'tempo' => NULL,
        ],
        [
            'author' => 'Billy Branch',
            'name' => 'Highway Blues',
            'tempo' => 120,
        ],
        [
            'author' => 'Whitesnake',
            'name' => 'Is this Love',
            'tempo' => 92,
        ],
        [
            'author' => 'Good Golly',
            'name' => 'Miss Molly',
            'tempo' => 175,
        ],
        [
            'author' => 'Def Leppard',
            'name' => 'Animal',
            'tempo' => 122,
        ],
        [
            'author' => 'Tito & Tarantula',
            'name' => 'After Dark',
            'tempo' => 100,
        ],
        [
            'author' => 'One Direction',
            'name' => 'One way',
            'tempo' => 160,
        ],
        [
            'author' => 'Yeganov Project',
            'name' => 'Money-Honey',
            'tempo' => 135,
        ],
        [
            'author' => 'Bryan Adams',
            'name' => 'East side story',
            'tempo' => 100,
        ],
        [
            'author' => 'Def Leppard',
            'name' => 'Gimme a Job',
            'tempo' => 130,
        ],
        [
            'author' => 'ZZ Top',
            'name' => 'Sharp Dressed Man',
            'tempo' => NULL,
        ],
        [
            'author' => 'Depeche Mode',
            'name' => 'Personal Jesus',
            'tempo' => 125,
        ],
        [
            'author' => 'Deep purple',
            'name' => 'Smoke on the Water',
            'tempo' => 115,
        ],
        [
            'author' => 'King Size',
            'name' => 'Забудь мене',
            'tempo' => NULL,
        ],
        [
            'author' => 'Bryan Adams',
            'name' => 'Summer of \'69',
            'tempo' => NULL,
        ],
        [
            'author' => 'Yeganov Project',
            'name' => 'Танго на попелі',
            'tempo' => 125,
        ],
        [
            'author' => 'Airbourne',
            'name' => 'Live it up!',
            'tempo' => 140,
        ],
        [
            'author' => 'Брати Гадюкіни',
            'name' => 'Дівчина з Коломиї',
            'tempo' => NULL,
        ],
        [
            'author' => 'Ozzy Osbourne',
            'name' => 'No more tears',
            'tempo' => NULL,
        ],
        [
            'author' => 'Krokus',
            'name' => 'Born to be wild',
            'tempo' => 140,
        ],
        [
            'author' => 'AC/DC',
            'name' => 'Highway to hell',
            'tempo' => 120,
        ],
        [
            'author' => 'Nirvana',
            'name' => 'Smells like teen spirit',
            'tempo' => 115,
        ],
        [
            'author' => 'HIM',
            'name' => 'Wicked game',
            'tempo' => 120,
        ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('songs')->insert(static::DEFAULT_SONGS);
    }
}

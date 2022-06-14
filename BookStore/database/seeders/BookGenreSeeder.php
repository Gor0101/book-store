<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            ['genre' => 'Detective'],
            ['genre' => 'Fantasy'],
            ['genre' => 'Novel'],
            ['genre' => 'Humor'],
            ['genre' => 'Scientific'],
        ]);
    }
}

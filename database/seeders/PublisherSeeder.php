<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publishers')->insert([
            'id' => 1,
            'name' => 'Gramedia'
        ]);

        DB::table('publishers')->insert([
            'id' => 2,
            'name' => 'Andi Offset'
        ]);

        DB::table('publishers')->insert([
            'id' => 3,
            'name' => 'Airlangga'
        ]);
    }
}
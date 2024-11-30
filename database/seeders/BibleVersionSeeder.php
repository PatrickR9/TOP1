<?php

namespace Database\Seeders;

use App\Models\BibleVersion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibleVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BibleVersion::factory(10)->create();
    }
}

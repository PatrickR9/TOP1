<?php

namespace Database\Seeders;

use App\Models\BibleBook;
use Illuminate\Support\Str;
use App\Models\BibleVersion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibleBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bibleVersions = BibleVersion::all();

        foreach ($bibleVersions as $bibleVersion) {
            $position = 1;

            for ($i = 0; $i < 20; $i++) {
                BibleBook::create([
                    'api_id' => Str::uuid()->toString(),
                    'name' => fake()->word(),
                    'position' => $position++,
                    'bible_version_id' => $bibleVersion->id,
                ]);
            }
        }
    }
}

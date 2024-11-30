<?php

namespace Database\Seeders;

use App\Models\BibleVerse;
use Illuminate\Support\Str;
use App\Models\BibleChapter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibleVerseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bibleChapters = BibleChapter::all();

        foreach ($bibleChapters as $bibleChapter) {
            $number = 1;

            for ($i = 0; $i < 10; $i++) {
                BibleVerse::create([
                    'api_id' => Str::uuid()->toString(),
                    'number' => $number++,
                    'text' => fake()->sentence(),
                    'bible_chapter_id' => $bibleChapter->id,
                ]);
            }
        }
    }
}

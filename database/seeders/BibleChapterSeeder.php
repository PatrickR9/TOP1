<?php

namespace Database\Seeders;

use App\Models\BibleBook;
use Illuminate\Support\Str;
use App\Models\BibleChapter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BibleChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bibleBooks = BibleBook::all();

        foreach ($bibleBooks as $bibleBook) {
            $number = 1;

            for ($i = 0; $i < 20; $i++) {
                BibleChapter::create([
                    'api_id' => Str::uuid()->toString(),
                    'number' => $number++,
                    'bible_book_id' => $bibleBook->id,
                ]);
            }
        }
    }
}

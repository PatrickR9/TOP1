<?php

namespace App\Http\Classes;

use App\Models\BibleBook;
use App\Models\BibleVerse;
use App\Models\BibleChapter;
use App\Models\BibleVersion;

class BibleService
{
    public function getBooksByVersion($versionId)
    {
        if (empty($versionId)) {
            return null;
        }

        $books = BibleBook::where('bible_version_id', $versionId)->get();

        if ($books->isEmpty()) {
            $error = null;
            $apiBooks = $this->fetchBooksFromApi($versionId, $error);
            if (!empty($error)) {
                dd($error);
            }

            $this->storeBibleBooks($apiBooks, $versionId);

            $books = BibleBook::where('bible_version_id', $versionId)->get();
        }

        return $books;
    }

    public function getChaptersByBook($bookId)
    {
        $chapters = BibleChapter::where('bible_book_id', $bookId)->get();

        if ($chapters->isEmpty()) {
            $error = null;
            $apiChapters = $this->fetchChaptersFromApi($bookId, $error);
            if (!empty($error)) {
                dd($error);
            }

            $this->storeBibleChapters($apiChapters, $bookId);

            $chapters = BibleChapter::where('bible_book_id', $bookId)->get();
        }

        return $chapters;
    }

    public function getVersesByChapter($chapterId)
    {
        $verses = BibleVerse::where('bible_chapter_id', $chapterId)->get();

        if ($verses->isEmpty()) {
            $error = null;
            $apiVerses = $this->fetchVersesFromApi($chapterId, $error);
            if (!empty($error)) {
                dd($error);
            }

            $this->storeBibleVerses($apiVerses, $chapterId);

            $verses = BibleVerse::where('bible_chapter_id', $chapterId)->get();
        }

        return $verses;
    }

    public function getVerse($verseId)
    {
        $verse = BibleVerse::where('id', $verseId)->first();

        if ($verse === null || $verse->content === null) {
            $error = null;
            $apiVerse = $this->fetchVerseFromApi($verseId, $error);
            if (!empty($error)) {
                dd($error);
            }

            $this->storeBibleVerseContent($apiVerse, $verseId);

            $verse = BibleVerse::where('id', $verseId)->first();
        }

        return $verse;
    }

    public function getChapter($chapterId)
    {
        $chapter = BibleChapter::where('id', $chapterId)->first();

        if ($chapter === null || $chapter->content === null) {
            $error = null;
            $apiChapter = $this->fetchChapterFromApi($chapterId, $error);
            if (!empty($error)) {
                dd($error);
            }
            $this->storeBibleChapterContent($apiChapter, $chapterId);

            $chapter = BibleChapter::where('id', $chapterId)->first();
        }

        return $chapter;
    }

    public function fetchBibleVerseOrPassage($query, &$error)
    {
        $urlSafeQuery = urlencode($query);

        $url = env('BIBLE_API_BASE_URL') . "bibles/9c11d46ebbfba585-01/search?query={$urlSafeQuery}";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }

    private function fetchChapterFromApi($chapterId, &$error)
    {
        $apiBibleId = BibleChapter::find($chapterId)->bibleBook->bibleVersion->api_id;
        if (empty($apiBibleId)) {
            $error = 'Bible not found.';
            return null;
        }

        $apiChapterId = BibleChapter::where('id', $chapterId)->pluck('api_id')->first();
        if (empty($apiChapterId)) {
            $error = 'Chapter not found.';
            return null;
        }

        $url = env('BIBLE_API_BASE_URL') . "bibles/{$apiBibleId}/chapters/{$apiChapterId}?content-type=html&include-notes=false&include-titles=false&include-chapter-numbers=false&include-verse-numbers=true&include-verse-spans=false";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }

    private function fetchVerseFromApi($verseId, &$error)
    {
        $apiBibleId = BibleVerse::find($verseId)->bibleChapter->bibleBook->bibleVersion->api_id;
        if (empty($apiBibleId)) {
            $error = 'Bible not found.';
            return null;
        }
        
        $apiVerseId = BibleVerse::where('id', $verseId)->pluck('api_id')->first();
        if (empty($apiVerseId)) {
            $error = 'Verse not found.';
            return null;
        }

        $url = env('BIBLE_API_BASE_URL') . "bibles/{$apiBibleId}/verses/{$apiVerseId}?content-type=html&include-notes=false&include-titles=false&include-chapter-numbers=false&include-verse-numbers=false&include-verse-spans=false";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }

    private function fetchVersesFromApi($chapterId, &$error)
    {
        $apiBibleId = BibleChapter::find($chapterId)->bibleBook->bibleVersion->api_id;
        if (empty($apiBibleId)) {
            $error = 'Bible not found.';
            return null;
        }

        $apiChapterId = BibleChapter::where('id', $chapterId)->pluck('api_id')->first();
        if (empty($apiChapterId)) {
            $error = 'Chapter not found.';
            return null;
        }

        $url = env('BIBLE_API_BASE_URL') . "bibles/{$apiBibleId}/chapters/{$apiChapterId}/verses";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }

    private function fetchBooksFromApi($versionId, &$error)
    {
        $apiBibleId = BibleVersion::where('id', $versionId)->value('api_id');

        if (empty($apiBibleId)) {
            $error = 'Bible not found.';
            return null;
        }

        $url = env('BIBLE_API_BASE_URL') . "bibles/{$apiBibleId}/books";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }

    private function fetchChaptersFromApi($bookId, &$error)
    {
        $apiBibleId = BibleBook::find($bookId)->bibleVersion->api_id;
        if (empty($apiBibleId)) {
            $error = 'Bible not found.';
            return null;
        }

        $apiBookId = BibleBook::where('id', $bookId)->pluck('api_id')->first();
        if (empty($apiBookId)) {
            $error = 'Book not found.';
            return null;
        }

        $url = env('BIBLE_API_BASE_URL') . "bibles/{$apiBibleId}/books/{$apiBookId}/chapters";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => base_path(env('CURLOPT_CAINFO_PATH')),
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'api-key: ' . env('BIBLE_API_KEY'),
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        if ($curlError) {
            $error = 'cURL Error: ' . $curlError;
            return null;
        }

        if ($httpCode !== 200) {
            $error = 'HTTP Error: ' . $httpCode;
            return null;
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'JSON decode error: ' . json_last_error_msg();
            return null;
        }

        if (empty($data)) {
            $error = 'Response data is empty.';
            return null;
        }

        return $data;
    }

    private function storeBibleChapterContent($apiChapter, $chapterId)
    {
        $chapterData = $apiChapter['data'];

        BibleChapter::updateOrCreate(
            [
                'id' => $chapterId,
                'api_id' => $chapterData['id']
            ],
            [
                'content' => $chapterData['content']
            ]
        );
    }

    private function storeBibleVerseContent($apiVerse, $verseId)
    {
        $verseData = $apiVerse['data'];

        BibleVerse::updateOrCreate(
            [
                'id' => $verseId,
                'api_id' => $verseData['id']
            ],
            [
                'content' => $verseData['content']
            ]
        );
    }

    private function storeBibleVerses($apiVerses, $chapterId)
    {
        $verses = $apiVerses['data'];

        foreach ($verses as $verseData) {
            BibleVerse::updateOrCreate(
                [
                    'api_id' => $verseData['id'],
                    'bible_chapter_id' => $chapterId
                ],
                [
                    'number' => $verseData['reference']
                ]
            );
        }
    }

    private function storeBibleBooks($apiBooks, $versionId)
    {
        $books = $apiBooks['data'];

        $position = 0;
        foreach ($books as $bookData) {
            $position += 1;
            BibleBook::updateOrCreate(
                [
                    'api_id' => $bookData['id'],
                    'bible_version_id' => $versionId,
                    'position' => $position
                ],
                [
                    'name' => $bookData['name']
                ]
            );
        }
    }

    private function storeBibleChapters($apiChapters, $bookId)
    {
        $chapters = $apiChapters['data'];

        foreach ($chapters as $chapterData) {
            BibleChapter::updateOrCreate(
                [
                    'api_id' => $chapterData['id'],
                    'bible_book_id' => $bookId
                ],
                [
                    'number' => $chapterData['number']
                ]
            );
        }
    }
}

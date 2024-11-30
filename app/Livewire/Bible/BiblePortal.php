<?php

namespace App\Livewire\Bible;

use Livewire\Component;
use App\Models\BibleBook;
use App\Models\BibleVerse;
use App\Models\BibleChapter;
use App\Models\BibleVersion;

class BiblePortal extends Component
{
    public $versions;
    public $selectedVersion = null;
    public $books = [];
    public $searchBook = '';
    public $selectedBook = null;
    public $selectedBookName = null;
    public $chapters = [];
    public $selectedChapter = null;
    public $chapterContent = '';
    public $verses = [];
    public $selectedVerse = null;
    public $passageMode = false;
    public $startVerse = null;
    public $endVerse = null;
    public $verseText = '';
    public $summary = '';
    public $searchTerm = '';
    public $searchResults = '';
    public $directQuery = '';
    public $directResult = '';

    public function mount()
    {
        $this->versions = BibleVersion::all();
    }

    public function directSearch()
    {
        if ($this->directQuery !== '') {
            $errorA = null;
            $directResultApi = app('App\Http\Classes\BibleService')->fetchBibleVerseOrPassage($this->directQuery, $errorA);
            if (empty($errorA)) {
                $this->directResult = $directResultApi['data']['passages'][0]['content'];
            }
            else {
                dd($errorA);
            }
        }
    }

    public function showChapter()
    {
        $this->chapterContent = app('App\Http\Classes\BibleService')->getChapter($this->selectedChapter);
    }

    public function search()
    {
        if ($this->searchTerm !== '') {
            $this->searchResults = BibleVerse::where('content', 'like', '%' . $this->searchTerm . '%')->get();
        }
        else {
            $this->searchResults = '';
        }
    }

    public function updatedSelectedVersion($versionId)
    {
        $this->books = app('App\Http\Classes\BibleService')->getBooksByVersion($versionId);
        $this->reset(['selectedBook', 'chapters', 'selectedChapter', 'verses', 'selectedVerse', 'passageMode', 'startVerse', 'endVerse', 'searchBook']);
    }

    public function updatedSearchBook($bookName)
    {
        $this->books = BibleBook::where('bible_version_id', $this->selectedVersion)
            ->where('name', 'like', '%' . $bookName . '%')
            ->get();
    }

    public function selectBook($bookId)
    {
        $this->selectedBookName = BibleBook::where('id', $bookId)->pluck('name')->first();
        $this->searchBook = $this->selectedBookName;
        $this->selectedBook = (string) $bookId;
        $this->chapters = app('App\Http\Classes\BibleService')->getChaptersByBook($bookId);
        $this->reset(['selectedChapter', 'verses', 'selectedVerse', 'passageMode', 'startVerse', 'endVerse']);
    }

    public function updatedSelectedChapter($chapterId)
    {
        $this->verses = app('App\Http\Classes\BibleService')->getVersesByChapter($chapterId);
        $this->reset(['selectedVerse', 'passageMode', 'startVerse', 'endVerse']);
    }

    public function togglePassageSelection()
    {
        $this->passageMode = !$this->passageMode;
        $this->reset(['startVerse', 'endVerse']);
    }

    public function selectVerse()
    {
        if (!$this->passageMode && $this->selectedVerse) {
            $verse = app('App\Http\Classes\BibleService')->getVerse($this->selectedVerse);

            if ($verse) {
                $this->verseText = $verse->content;
            }
        }
        $this->getSummary();
        $this->summary .= ' -> ' . BibleVerse::where('id', $this->selectedVerse)->pluck('number')->first();
    }

    public function selectPassage()
    {
        if ($this->passageMode && $this->startVerse && $this->endVerse) {
            $verses = BibleVerse::whereBetween('id', [$this->startVerse, $this->endVerse])->select('number', 'content')->get();

            if ($verses->isNotEmpty()) {

                $formattedVerses = [];

                foreach ($verses as $vers) {
                    $formattedVerses[] = $vers->number . ' ' . $vers->content;
                }

                $this->verseText = implode(' ', $formattedVerses);

                $this->getSummary();
                $this->summary .= ' -> Vers ' . BibleVerse::where('id', $this->startVerse)->pluck('number')->first();
                $this->summary .= '-' . BibleVerse::where('id', $this->endVerse)->pluck('number')->first();
            }
        }
    }

    private function getSummary()
    {
        $this->summary = BibleBook::where('id', $this->selectedBook)->pluck('name')->first();
        $this->summary .= ' -> Kapitel ' . BibleChapter::where('id', $this->selectedChapter)->pluck('number')->first();
    }

    public function render()
    {
        return view('livewire.bible.portal');
    }
}

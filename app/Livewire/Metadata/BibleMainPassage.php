<?php

namespace App\Livewire\Metadata;

use Livewire\Component;
use App\Models\BibleBook;
use App\Models\BibleVersion;

class BibleMainPassage extends Component
{
    # Bible passage
    public $bibleVersions = [];
    public $selectedBibleVersionId;
    public $searchStart = '';
    public $booksStart = [];
    public $noResultsStart = false;
    public $showDropdownStart = false;
    public $chapterStart;
    public $verseStart;
    public $searchEnd = '';
    public $booksEnd = [];
    public $noResultsEnd = false;
    public $showDropdownEnd = false;
    public $chapterEnd;
    public $verseEnd;
    public $biblePassage = '';
    public $passageName = '';
    public $bibleName = '';

    public function mount()
    {
        $this->bibleVersions = BibleVersion::all()->toArray();
        
        if (!empty($this->bibleVersions)) {
            $this->selectedBibleVersionId = $this->bibleVersions[0]['id'];
            $this->selectBibleVersion($this->selectedBibleVersionId);
        }
        $this->updateBookListStart();
        $this->updateBookListEnd();
    }

    public function updatedSearchStart()
    {
        $this->updateBookListStart();
        $this->showDropdownStart = true;
    }

    public function updatedSearchEnd()
    {
        $this->updateBookListEnd();
        $this->showDropdownEnd = true;
    }

    public function selectBookStart($bookName)
    {
        $this->searchStart = $bookName;
        $this->updatedSearchStart();
        $this->showDropdownStart = false;
    }

    public function selectBookEnd($bookName)
    {
        $this->searchEnd = $bookName;
        $this->updatedSearchEnd();
        $this->showDropdownEnd = false;
    }

    private function updateBookListStart()
    {
        $query = BibleBook::where('bible_version_id', $this->selectedBibleVersionId);

        if ($this->searchStart) {
            $query->where('name', 'like', '%' . $this->searchStart . '%');
        }

        $this->booksStart = $query->get();

        $this->noResultsStart = $this->booksStart->isEmpty() && !empty($this->searchStart);
        $this->showDropdownStart = !empty($this->searchStart);
    }

    private function updateBookListEnd()
    {
        $query = BibleBook::where('bible_version_id', $this->selectedBibleVersionId);

        if ($this->searchEnd) {
            $query->where('name', 'like', '%' . $this->searchEnd . '%');
        }

        $this->booksEnd = $query->get();

        $this->noResultsEnd = $this->booksEnd->isEmpty() && !empty($this->searchEnd);
        $this->showDropdownEnd = !empty($this->searchEnd);
    }

    public function selectBibleVersion($versionId)
    {
        $this->selectedBibleVersionId = $versionId;
        $this->updateBookListStart();
        $this->updateBookListEnd();
    }

    public function getBiblePassage()
    {
        $bibleApiId = BibleVersion::where('id', $this->selectedBibleVersionId)->value('api_id');
        $this->bibleName = BibleVersion::where('id', $this->selectedBibleVersionId)->value('name_local');

        if ($this->booksStart->count() === 1 && $this->booksEnd->count() === 1) {
            $bookApiIdStart = $this->booksStart->first()->api_id;
            $this->passageName = '';
            $this->passageName .= $this->booksStart->first()->name;
            $this->passageName .= " {$this->chapterStart}";
            $this->passageName .= ", {$this->verseStart}";
            $bookApiIdEnd = $this->booksEnd->first()->api_id;
            $this->passageName .= " - {$this->booksEnd->first()->name}";
            $this->passageName .= " {$this->chapterEnd}";
            $this->passageName .= ", {$this->verseEnd}";

            $passageFrom = $this->formatReference($bookApiIdStart, $this->chapterStart, $this->verseStart);
            $passageTo = $this->formatReference($bookApiIdEnd, $this->chapterEnd, $this->verseEnd);

            $error = null;
            $biblePassageApi = app('App\Http\Classes\BiblePassageService')->getPassage($bibleApiId, $passageFrom, $passageTo, $error);
            if (!empty($error)) {
                dd($error);
            }
            $this->biblePassage = $biblePassageApi['data']['content'];

        } elseif ($this->booksStart->isEmpty() || $this->booksEnd->isEmpty()) {
            dump('Mindestens ein Buch existiert nicht!');
        } else {
            dump('Mindestens ein Buch wurde nicht eindeutig spezifiziert!');
        }
    }

    public function removeBiblePassage()
    {
        $this->biblePassage = '';
    }

    private function formatReference($bookApiId, $chapter, $verse)
    {
        return "{$bookApiId}.{$chapter}.{$verse}";
    }

    public function render()
    {
        return view('livewire.metadata.bible-main-passage');
    }
}

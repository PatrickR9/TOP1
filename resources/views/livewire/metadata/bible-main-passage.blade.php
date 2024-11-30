<div>
    <div class="bible_main_container">
        <div class="bible_container_row">
            <div class="bible_badge_container">
                @foreach($bibleVersions as $version)
                <div
                    class="bible_badge {{ $selectedBibleVersionId === $version['id'] ? 'selected' : '' }}"
                    wire:click="selectBibleVersion({{ $version['id'] }})">
                    {{ $version['name_local'] }}
                </div>
                @endforeach
            </div>
        </div>
        <div class="bible_container_row">
            <div class="bible_input_container">
                <div class="bible_book_container">
                    <input
                        type="text"
                        placeholder="1. Mose"
                        class="bible_book"
                        wire:model.live.debounce.250ms="searchStart"
                        wire:focus="$set('showDropdownStart', true)"
                        wire:blur="$set('showDropdownStart', false)" />

                    @if($showDropdownStart)
                    <ul class="filtered-list">
                        @if(!empty($booksStart))
                        @foreach($booksStart as $book)
                        <li class="cursor-pointer" wire:click="selectBookStart('{{ $book->name }}')">
                            {{ $book->name }}
                        </li>
                        @endforeach
                        @endif
                        @if($noResultsStart)
                        <li class="no_search_results">Keine Bücher gefunden.</li>
                        @endif
                    </ul>
                    @endif
                </div>
                <div class="bible_chapter_container">
                    <input type="text" placeholder="1" class="numeric_input bible_chapter" wire:model.lazy="chapterStart">
                </div>
                <span class="separator_bible">;</span>
                <div class="bible_verse_container">
                    <input type="text" placeholder="1" class="numeric_input bible_verse" wire:model.lazy="verseStart">
                </div>
                <span>bis</span>
                <div class="bible_book_container">
                    <input
                        type="text"
                        placeholder="1. Mose"
                        class="bible_book"
                        wire:model.live.debounce.250ms="searchEnd"
                        wire:focus="$set('showDropdownEnd', true)"
                        wire:blur="$set('showDropdownEnd', false)" />

                    @if($showDropdownEnd)
                    <ul class="filtered-list">
                        @if(!empty($booksEnd))
                        @foreach($booksEnd as $book)
                        <li class="cursor-pointer" wire:click="selectBookEnd('{{ $book->name }}')">
                            {{ $book->name }}
                        </li>
                        @endforeach
                        @endif
                        @if($noResultsEnd)
                        <li class="no_search_results">Keine Bücher gefunden.</li>
                        @endif
                    </ul>
                    @endif
                </div>
                <div class="bible_chapter_container">
                    <input type="text" placeholder="1" class="numeric_input bible_chapter" wire:model.lazy="chapterEnd">
                </div>
                <span class="separator_bible">;</span>
                <div class="bible_verse_container">
                    <input type="text" placeholder="1" class="numeric_input bible_verse" wire:model.lazy="verseEnd">
                </div>
                <button class="bible_btn_search" wire:click="getBiblePassage()">Bibelstelle suchen</button>
            </div>
        </div>
        <div class="bible_container_row">
            @if($biblePassage)
            <div class="bible_result_container">
                <div class="bible_result_header">
                    <span class="bible_result_title">{{ $passageName }}</span>
                    <span class="bible_result_container_badge"><strong>{{ $bibleName }}</strong></span>
                </div>
                <div class="bible_result_content">
                    <div class="bible_result_text">
                        <span class="bible_result_border">{!! $biblePassage !!}</span>
                    </div>
                </div>
                <div class="bible_result_remove_icon" wire:click="removeBiblePassage()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="12" height="12">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" fill="#45464a"></path>
                    </svg>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script>
        const inputFields = document.querySelectorAll('.numeric_input');

        inputFields.forEach(inputField => {
            inputField.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
</div>
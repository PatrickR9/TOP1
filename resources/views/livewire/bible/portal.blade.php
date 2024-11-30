<div>
    <style>
        .filtered-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            max-height: 200px;
            overflow-y: auto;
            list-style-type: none;
            padding-left: 0;
            z-index: 10;
        }

        .filtered-list li:hover {
            background-color: #f1f1f1;
        }

        .search-container {
            position: relative;
            flex-wrap: nowrap;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .bible_container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .bible_block_title {
            position: relative;
            width: 100%;
            padding: 12px 20px 12px;
            font-size: 15pt;
            background-image: linear-gradient(#30c3bd, #248f8b, #145250);
            color: #FFF;
            margin-bottom: 20px;
        }

        .bible_block {
            background-color: #FFF;
            border: 1px solid #AAA;
            width: calc(100% - 40px);
            margin: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .bible_search_result_box {
            background-color: #FFF;
            border: 1px solid #AAA;
            width: calc(100% - 40px);
            margin: auto;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 20px;
        }

        .bible_search_result_list {
            margin-top: 8px;
            margin-bottom: 6px;
        }
    </style>
    <!-- Direktsuche -->
    <div class="bible_block">
        <p class="bible_block_title"><strong>Direkt suchen</strong></p>
        <div class="bible_container">
            <!-- Suchfeld -->
            <div>
                <label for="directQuery">Bibelstelle angeben:</label>
                <input type="text" id="directQuery" wire:model="directQuery" placeholder="z.B. Genesis 1:2-3">

                <button type="button" wire:click="directSearch" class="management_button">Suchen</button>
            </div>
        </div>
    </div>
    <!-- Anzeige der Ergebnisse aus der Direktsuche -->
    @if ($directResult)
    <div class="bible_search_result_box">
        {!! $directResult !!}
    </div>
    @endif

    <!-- Interaktive Suche -->
    <div class="bible_block">
        <p class="bible_block_title"><strong>Interaktiv suchen</strong></p>
        <div class="bible_container">
            <!-- Bibelversion Auswahl -->
            <div>
                <label for="version">Bibelversion auswählen:</label>
                <select wire:model.live="selectedVersion" id="version">
                    <option value="" hidden>Wähle eine Version aus</option>
                    @foreach($versions as $version)
                    <option value="{{ $version->id }}">{{ $version->name_local }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Suchfeld für Bücher -->
            @if($selectedVersion)
            <div class="search-container" x-data="{ isOpen: false }" @click.away="isOpen = false">
                <label for="searchBook">Buch suchen:</label>
                <input
                    type="text"
                    wire:model.live.debounce.250ms="searchBook"
                    value="{{ $selectedBookName }}"
                    id="searchBook"
                    placeholder="Buch eingeben..."
                    class="search-input"
                    @focus="isOpen = true"
                    @keydown.escape.window="isOpen = false">

                <!-- Ergebnisliste -->
                @if($books->isNotEmpty())
                <ul
                    class="filtered-list"
                    x-show="isOpen"
                    @click="isOpen = false">
                    @foreach($books as $book)
                    <li wire:click="selectBook({{ $book->id }})" class="cursor-pointer">
                        {{ $book->name }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500 mt-2">Keine Bücher gefunden.</p>
                @endif
            </div>
            @endif

            <!-- Kapitel Dropdown -->
            @if($selectedBook)
            <div>
                <label for="chapter">Kapitel auswählen:</label>
                <select wire:model.live="selectedChapter" id="chapter">
                    <option value="" hidden>Wähle ein Kapitel aus</option>
                    @foreach($chapters as $chapter)
                    <option value="{{ $chapter->id }}">{{ $chapter->number }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Vers oder Passage Auswahl -->
            @if($selectedChapter)
            <div>
                <button wire:click="togglePassageSelection" type="button" class="management_button">
                    @if($passageMode)
                    Einzelnen Vers auswählen
                    @else
                    Passage auswählen
                    @endif
                </button>
            </div>

            @if($passageMode)
            <!-- Passage Auswahl -->
            <div>
                <label for="startVerse">Start-Vers:</label>
                <select wire:model.live="startVerse" id="startVerse" wire:change="selectPassage">
                    <option value="" hidden>Start-Vers wählen</option>
                    @foreach($verses as $verse)
                    <option value="{{ $verse->id }}">{{ $verse->number }}</option>
                    @endforeach
                </select>

                @if($startVerse)
                <label for="endVerse">End-Vers:</label>
                <select wire:model.live="endVerse" id="endVerse" wire:change="selectPassage">
                    <option value="" hidden>End-Vers wählen</option>
                    @foreach($verses as $verse)
                    @if($verse->id > $verses->firstWhere('id', $startVerse)->id)
                    <option value="{{ $verse->id }}">{{ $verse->number }}</option>
                    @endif
                    @endforeach
                </select>
                @endif
            </div>
            @else
            <!-- Einzelnen Vers auswählen -->
            <div>
                <label for="selectVerse">Vers auswählen:</label>
                <select wire:model.live="selectedVerse" id="selectVerse" wire:change="selectVerse">
                    <option value="" hidden>Wähle einen Vers aus</option>
                    @foreach($verses as $verse)
                    <option value="{{ $verse->id }}">{{ $verse->number }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @endif
        </div>
    </div>
    <!-- Anzeige der ausgewählten Bibelstelle -->
    @if ($verseText)
    <div class="bible_search_result_box">
        <h4>{{ $summary }}</h4>
        {!! $verseText !!}
        <br>
        <button type="button" wire:click="showChapter" class="management_button">Kapitel Anzeigen</button>
    </div>
    @endif

    <!-- Anzeige eines Kapitels -->
    @if ($chapterContent)
    <div class="bible_search_result_box">
        <h4>Kapitel {{ $chapterContent->number }}</h4>
        {!! $chapterContent->content !!}
    </div>
    @endif

    <!-- Suche nach Stichwort -->
    <div class="bible_block">
        <p class="bible_block_title"><strong>Stichwort suchen</strong></p>
        <div class="bible_container">
            <!-- Suchfeld -->
            <div>
                <label for="searchTerm">Suchbegriff:</label>
                <input type="text" id="searchTerm" wire:model="searchTerm" placeholder="Stichwort eingeben...">

                <button type="button" wire:click="search" class="management_button">Suchen</button>
            </div>
        </div>
    </div>
    <!-- Anzeige der Suchergebnisse -->
    @if ($searchResults)
    <div class="bible_search_result_box">
        <h4>Suchergebnisse für: "{{ $searchTerm }}"</h4>
        @forelse ($searchResults as $result)
        <div class="bible_search_result_list">
            <strong>{{ $result->number }}</strong>
            {!! $result->content !!}
        </div>
        @if(!$loop->last)
        <hr>
        @endif
        @empty
        <p>Keine Ergebnisse gefunden.</p>
        @endforelse
    </div>
    @endif
</div>
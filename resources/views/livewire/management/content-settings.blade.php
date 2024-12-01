<div class = "management_block">
    <div class="accordion-container">
        @foreach ($sections as $index => $section)
            <div class="accordion">

                <div class="accordion-header" wire:click="$toggle('sections.{{$index}}.isOpen')">
                    <div class="header-left">
                        {!! $section['icon'] !!}
                        <span class="label">{{ $section['label'] }}</span>
                    </div>
                    <div class="header-right">
                        @if ($section['rightText'])
                            <span class="right-text">{{ $section['rightText'] }}</span>
                        @endif
                        <svg class="toggle-icon {{ $section['isOpen'] ?? false ? 'open' : '' }}" xmlns="https://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#45464A">
                            <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"></path>
                        </svg>
                    </div>
                </div>

                @if ($section['isOpen'] ?? false)
                    <div class="accordion-content">
                        @foreach ($section['content'] as $content)
                            @if ($content['description'])
                                <p class="description">{{ $content['description'] }}</p>
                            @endif
                            @if ($content['label'])
                                <label class="content-label">{{ $content['label'] }}</label>
                            @endif
                            @switch($content['type'])
                                @case('platform')
                                    <div class="platform_wrapper">
                                        @for ($i = 1; $i < 4; $i++)
                                            <div class="platform_box">
                                                <div class="platform">
                                                    <input type="checkbox" id="platform{{ $i }}">
                                                    <label>Plattform {{ $i }}</label>
                                                </div>
                                                <x-layout-settings />
                                            </div>
                                        @endfor
                                    </div>
                                    @break
                                @case('publication')
                                    <div class="publication_wrapper">
                                        <div class="publication_checkbox">
                                            <input type="checkbox" id="publicationOffline">
                                            <label>Jetzt offline schalten</label>
                                        </div>
                                        <div class="publication_date">
                                            <label>Einheit offline schalten zum:</label><br>
                                            <input type="date" class="content-date" id="publicationOfflineDate">
                                            <input type="time" class="content-time" id="publicationOfflineTime">
                                        </div>
                                    </div>
                                    <div class="publication_wrapper">
                                        <div class="publication_checkbox">
                                            <input type="checkbox" id="publicationOnline">
                                            <label>Jetzt veröffentlichen</label>
                                        </div>
                                        <div class="publication_date">
                                            <label>Einheit veröffentlichen zum:</label><br>
                                            <input type="date" class="content-date" id="publicationOnlineDate">
                                            <input type="time" class="content-time" id="publicationOnlineTime">
                                        </div>
                                    </div>
                                    @break
                                @case('toogle_switch')
                                    <div class="settings_switch">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider"></span>
                                        </label>
                                        <label>Aus der Suche ausschließen</label>
                                    </div>
                                    @break
                                @case('text')
                                    <input type="text" class="content-input" placeholder="{{ $content['placeholder'] ?? '' }}">
                                    @break
                                @case('longtext')
                                    <textarea class="content-textarea" rows="4" wire:model.live="textareaContent"></textarea>
                                    <div class="char_count">
                                        <p><span>{{ $charCount }}</span>/<span class="max_char_number">300</span></p>
                                    </div>
                                    @break
                                @case('date')
                                    <input type="date" class="content-date">
                                    @break
                                @case('author')
                                    @livewire('metadata.author-selection')
                                    @break
                            @endswitch
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

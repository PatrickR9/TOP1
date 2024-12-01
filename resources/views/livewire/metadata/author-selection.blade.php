<div>
    @if ($selectedItems)
    <div class="autocomplete_container_row">
        <div class="ac_badges_container">
            @foreach ($selectedItems as $item)
            <div class="ac_badge" wire:click="removeItem({{ $item->id }})">
                {{ $item->name }}
                <svg class="ac_badge_remove" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                    <path fill="#fff" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                </svg>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="autocomplete_container_row">
        <div class="autocomplete_container">
            <div class="autocomplete_dropdown">
                <input type="text" placeholder="{{ $placeholderText }}" class="ac_search_input"
                    wire:model.live.debounce.250ms="search" wire:focus="$set('showDropdown', true)"
                    wire:blur="$set('showDropdown', false)" />

                @if ($showDropdown)
                <ul class="filtered-list">
                    @if (!empty($items))
                    @foreach ($items as $item)
                    <li class="cursor-pointer" wire:click="selectItem('{{ $item->id }}')">
                        {!! preg_replace("/(" . preg_quote($search) . ")/i", "<strong>$1</strong>", $item->name) !!}
                    </li>
                    @endforeach
                    @endif
                    @if ($noResults)
                    <li class="no_search_results">Keine Ergebnisse gefunden.</li>
                    @endif
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
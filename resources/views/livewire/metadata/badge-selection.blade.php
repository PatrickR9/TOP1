<div>
    <div>
        @if ($selectedBadgeId)
        <div id="selected-badges" class="mediatypes_badge_row">
            @foreach ($badges as $badge)
                @if ($badge['selected'])
                    <div class="mt_badge selectedMediaType" wire:click="toggleBadge({{ $badge['id'] }}, false)">
                        {{ $badge['name'] }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="12" height="12" class="category_selected_item_remove">
                            <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" fill="#fff"></path>
                        </svg>
                    </div>
                @endif
            @endforeach
        </div>
        @endif

        @if (!$selectedBadgeId)
        <div id="unselected-badges" class="mediatypes_badge_row">
            @foreach ($badges as $badge)
                @if (!$badge['selected'])
                    <div class="mt_badge" wire:click="toggleBadge({{ $badge['id'] }}, false)">
                        {{ $badge['name'] }}
                    </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</div>
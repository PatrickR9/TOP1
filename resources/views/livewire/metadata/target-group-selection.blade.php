<div id="targetGroups">
    <div class="category_dropdown">
        <div class="category_selected_list" id="targetGroupsSelectedList"></div>
        @foreach ($targetGroupTypes as $targetGroupType)
            <div class="main_category_dd" id="targetGroupsMainCategory{{ $loop->index }}" 
                 onclick="toggleSubEntries('targetGroups', {{ $loop->index }})">
                <span class="main_category_dd-text">{{ $targetGroupType->name }}</span>
                <svg class="main_category_icon_chevron" id="targetGroupsArrow{{ $loop->index }}" 
                     xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#45464A">
                    <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                </svg>
            </div>
            
            <div class="category_sub_entries" id="targetGroupsSubEntries{{ $loop->index }}" style="display: none;">
                @foreach ($targetGroupType->targetGroups as $targetGroup)
                    <div class="category_sub_entry">
                        <input id="targetGroup{{ $targetGroup->id }}" type="checkbox" value="{{ $targetGroup->name }}" onclick="handleCategorySelect('targetGroups', this, false)">
                        <label>{{ $targetGroup->name }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
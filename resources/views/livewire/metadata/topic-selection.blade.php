<div id="topics">
    <div class="category_dropdown">
        <div class="category_selected_list" id="topicsSelectedList"></div>

        @foreach ($topicTypes as $topicType)
            <div class="main_category_dd" id="topicsMainCategory{{ $loop->index }}" 
                 onclick="toggleSubEntries('topics', {{ $loop->index }})">
                <span class="main_category_dd-text">{{ $topicType->name }}</span>
                <svg class="main_category_icon_chevron" id="topicsArrow{{ $loop->index }}" 
                     xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#45464A">
                    <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                </svg>
            </div>

            <div class="category_sub_entries" id="topicsSubEntries{{ $loop->index }}" style="display: none;">
                @foreach ($topicType->topics as $topic)
                    <div class="category_sub_entry">
                        <input id="topic{{ $topic->id }}" type="checkbox" value="{{ $topic->name }}" onclick="handleCategorySelect('topics', this, false)">
                        <label>{{ $topic->name }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<div class = "admin_side_navigation admin_side_navigation_{{$currentStatus}}">
    <div class = "admin_side_navigation_header">Menü</div>
    <div class = "admin_side_navigation_control" wire:click="snToggle('{{$currentStatus}}')">
        <span class = "fa fa-navicon"></span>
        <span class = "icon_close">&#10006;</span>
    </div>
    <nav class = "admin_side_navigation_groups">
        @foreach($links as $linkGroup => $linkGroupData)
        <div class = "admin_side_navigation_group_label accordion_button_closed" onclick = "toggleAccordion(this)">
        {!!$linkGroupData['icon']!!}
            <span>{{$linkGroup}}</span>
            <div class="chevron_wrapper">
            <svg class="chevron_icon" xmlns="https://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#45464A">
                <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/>
            </svg>
            </div>
        </div>
        <ul class = "admin_side_navigation_group accordion_block_closed" style="max-height: 0">
            @foreach($linkGroupData['links'] as $urlData)
            @if(isset($urlData['url']))
                @if($currentUrl === $urlData['url'])
                    <li class = "admin_side_navigation_li_selected"><span>{{$urlData['label']}}</span></li>
                @else
                    <li class = "admin_side_navigation_li"><a href = "{{$urlData['url']}}">{{$urlData['label']}}</a></li>
                @endif
            @elseif(isset($urlData['wire:click']))
            <li class = "admin_side_navigation_li" wire:click="{{$urlData['wire:click']}}">{{$urlData['label']}}</li>
            @else
            <li class = "admin_side_navigation_li">{{$urlData['label']}}</li>
            @endif
            @endforeach
        </ul>
        @endforeach
    </nav>
</div>

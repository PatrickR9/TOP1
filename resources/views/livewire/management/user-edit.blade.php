<div class = "management_block">
    <ul class = "management_edit_tabs">
    @foreach($tabs as $tabIndex => $tab)
        @if($tabIndex === $selectedTab)
        <li class = "management_edit_tab selected" wire:click="selectTab('{{$tabIndex}}')">{{$tab['label']}}</li>
        @else
        <li class = "management_edit_tab" wire:click="selectTab('{{$tabIndex}}')">{{$tab['label']}}</li>
        @endif
    @endforeach
    </ul>
    <div class = "management_edit_block">
        @include('management.users.'.$selectedTab)
    </div>
</div>

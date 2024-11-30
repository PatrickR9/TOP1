<li class = "site_row">
    <div class = "site_row_label_block">
    @php $currentSite = $site; @endphp
    @switch($site['siteData']['id'])
        @case($siteId)
        <div class = "site_row_label_edit_block">
            <input type = "text" wire:model="siteTitle">
            <button type="button" class="management_button management_small_button fa fa-save" wire:click="titleSave()"></button>
            <button type="button" class="management_button management_small_button warning fa fa-close" wire:click="titleCancel()"></button>
        </div>
        @break;
        @default
        <span class = "site_row_label site_row_online_{{$statusValues[$site['siteData']['status']]}}">{{$site['siteData']['title']}}</span>
        <div class = "site_row_buttons">
            @if($site['siteData']['status'] === 0)
            <button type = "button" class = "management_button management_small_button warning fa fa-power-off" wire:click="siteSetOnline({{$site['siteData']['id']}})"></button>
            @else
            <button type = "button" class = "management_button management_small_button on fa fa-power-off" wire:click="siteSetOffline({{$site['siteData']['id']}})"></button>
            @endif
            <button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click = "titleEdit({{$site['siteData']['id']}});"></button>
            <button type="button" class="management_button management_small_button fa fa-plus" wire:click="newSite({{$site['siteData']['id']}})"></button>
            <a href = "/edit/{{$site['siteData']['id']}}" target = "d_editor"><button type = "button" class = "management_button management_small_button fa fa-edit"></button></a>
        </div>
    @endswitch
    </div>
    @if((count($site['subSites']) > 0) || ($site['siteData']['id'] === $parentId))
    <div class = "site_row_sub_block">
        @if(($site['siteData']['id'] === $parentId))
        <div class = "site_row_label_edit_block">
            <input type = "text" wire:model="subSiteTitle" placeholder = "Seitenname">
            <button type="button" class="management_button management_small_button fa fa-save" wire:click="newSiteSave()"></button>
            <button type="button" class="management_button management_small_button warning fa fa-close" wire:click="newSiteCancel()"></button>
        </div>
        @endif
        <span class = "site_row_button accordion_button" onclick="toggleAccordion(this)"><span class = "accordion_button_plus">+</span><span class = "accordion_button_minus">-</span></span>
        <ul class = "accordion_block">
            @foreach($currentSite['subSites'] as $site)
                @include('d_editor.sitemaplevel', $site)
            @endforeach
        </ul>
    </div>
    @endif
</li>

<div class = "management_top_block">
@switch($selectedFunction)
    @case('toListPrepare')
    <div class = "management_top_left_block">
        <button type = "button" class = "management_button" wire:click="toList()"><i class = "fa fa-arrow-left"></i>zur Liste</button>
    </div>
    <div class = "management_top_center_block">
        <p>Die Änderungen müssen gespeichert werden</p>
    </div>
    <div class = "management_top_right_block">
        <button type = "button" class = "management_button" wire:click="saveAndList()">speichern und zur Liste</button>
        <button type = "button" class = "management_button" wire:click="toEdit()">weiter bearbeiten<i class = "fa fa-arrow-right"></i></button>
    </div>
    @break;
    @default
    <div class = "management_top_left_block">
        <button type = "button" class = "management_button" wire:click="toListPrepare()"><i class = "fa fa-arrow-left"></i>verlassen</button>
    </div>
    <div class = "management_top_center_block">
        @if(in_array($step, [2, 3, 4]))
            @if($step === 2)
            <button type = "button" class = "management_button" onclick="siteSave(false)">{{$currentSiteName}} - speichern</button>
            @else
            <button type = "button" class = "management_button" wire:click="apply()">{{$currentSiteName}} - speichern</button>
            @endif
        <ul class = "management_top_history_block{{$addClass}}" id = "management_top_history_block">
        @foreach($currentUserSiteVersions as $versionType => $versionTypeRows)
            <li class = "li_group">
            @switch($versionType)
                @case('vt100')
                Live Version übernehmen:
                @break
                @case('vt0')
                aktuelle Version öffnen:
                @break
                @case('vt1')
                @break
                ältere Version öffnen:
                @case('vt2')
                automatisch gepeichert
                @break
            @endswitch
            </li>
            @foreach($versionTypeRows as $versionNumber => $versions)
                @foreach($versions as $version)
            <li wire:click="reloadVersion('{{$versionType}}', '{{$versionNumber}}')"><span class = "li_label_date">{{$version['date']}}</span><span class = "li_label_date">{{$version['time']}}</span></li>
                @endforeach
            @endforeach
        @endforeach
        </ul>
        @else
        <button type = "button" class = "management_button" wire:click="apply({{$step}})">{{$currentSiteName}} - speichern</button>
        @endif
    </div>
    <div class = "management_top_right_block">
        @if($step === 2)
        <button type = "button" class = "management_button" onclick="siteSave(true)">weiter zu Schritt {{$step + 1}}<i class = "fa fa-arrow-right"></i></button>
        @else
        <button type = "button" class = "management_button" wire:click="saveAndNext()">weiter zu Schritt {{$step + 1}}<i class = "fa fa-arrow-right"></i></button>
        @endif    
    </div>
    @break;
@endswitch
</div>

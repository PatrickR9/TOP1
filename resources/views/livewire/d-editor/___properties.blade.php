<div class = "{{$blockPropertyBoxClass}}">
    <p style = "color: #FFF;">{{$msg}}</p>
    <input class = "sinput_hidden" readonly type = "text" id = "currentBlockId" wire:change="loadBlockProperties(currentBlockId.value)">
    @if(isset($userSiteBlockAttribs))
    @foreach($userSiteBlockAttribs as $attribCategoryName => $attribValues)
    <div class = "w100">
        @foreach($attribValues as $attribName => $attribValue)
        <label class = "management_floating_label">{{$attribName}}</label>
        <select class = "w100" wire:model = "userSiteBlockAttribs.{{$attribCategoryName}}.{{$attribName}}" wire:change="setBlockAttributes('{{$attribCategoryName}}')" onchange = "setAttribStatus()">
            {!! $classOptions[$attribName] !!}
        </select>
        @endforeach
    </div>
    @endforeach
    @endif
    <input type = "hidden" style ="border: 1px solid #555;" id = "_activityController" wire:change="setLastActivity()" wire:click="leaveEditor(1)">
    @if($leavePrepared === true)
        @include('d_editor.popup', ['popupParams' => $popupParams])
    @endif
</div>

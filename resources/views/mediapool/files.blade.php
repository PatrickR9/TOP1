    <div class = "media_pool_body">
        @php 
            $_mediaToDelete = [];
        @endphp
        @foreach($pool['files'] as $mediumFile => $mediumAttribs)
            @if(isset($mediumAttribs['deletable']))
                @if ($mediumAttribs['deletable'] === true)
                    @php
                    $_deleteStatus = 'del';
                    $_mediaToDelete[] = $mediumFile;
                    @endphp
                @else
                    @php
                    $_deleteStatus = 'in_use';
                    @endphp
                @endif
            @else
                @php
                $_deleteStatus = '';
                @endphp
            @endif

            <div class = "media_pool_row selectable">
                <div class = "media_pool_file">
                    <div  class = "management_img_small_preview">
                        <img src = "{{route('image.show', ['mediaId' => $mediumAttribs['media_id']])}}">
                    </div>
                    <span class = "management_img_name">{{$mediumFile}}</span>
                </div>
                <div class = "media_pool_label">
                @if($mediumFile === $mediumToEdit)
                    <input type = "text" wire:model="mediumLabelToEdit">
                    <select wire:model="editCategoryId">
                        <option value = "0"> - keine Kategorie -</option>
                        {!!$categoryOptions!!}
                    </select>
                    <button class = "management_button management_small_button" wire:click="updateMediumLabel({{$mediumAttribs['media_id']}})"><span class = "fa fa-save"></span></button>
                    <button class = "management_button management_small_button" wire:click="cancelMediumLabel()"><span class = "fa fa-close"></span></button>
                @else
                    {{$mediumAttribs['label']}}
                @endif
                </div>
                <div class = "media_pool_type">
                    {{$mediumAttribs['mime_type']}}
                </div>
                <div class = "media_pool_size">
                    {{$mediumAttribs['size']}}
                </div>
                <div class = "media_pool_control">
                @if($mediumFile === $mediumToEdit)

                @else
                    @if(isset($pool['target']))
                    <button class = "management_button" wire:click="setMedium('{{$mediumAttribs['media_id']}}')"><span class = "fa fa-arrow-circle-left"></span> <span class = "fa fa-image"></span></button>
                    @endif
                    <button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click="editMedium('{{$mediumAttribs['media_id']}}')"></button>
                    @switch($_deleteStatus)
                    @case('del')
                    <span class = "management_img_msg center warning">{{__('permanently delete')}} <button type = "button" class = "management_button management_small_button fa fa-undo" wire:click="unDeleteMedium('{{$mediumAttribs['media_id']}}')"></button></span>
                    @break
                    @case('in_use')
                    <span class = "management_img_msg">{{__('image in use')}}</span>
                    @break
                    @default
                    <button type = "button" class = "management_button management_small_button warning fa fa-trash-o" wire:click="deleteMedium('{{$mediumAttribs['media_id']}}')"></button>
                    @break;
                    @endswitch
                @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class = "media_pool_footer">
        <div class = "media_pool_row">
            <form action = "" wire:submit="addMedia()">
                <label>Media hinzufügen</label>
                <input type = "file" wire:model="newMedia" multiple>
                <button type = "submit" class = "management_button">{{__('upload')}}</button>
            </form>
        </div>
        @if(count($_mediaToDelete) > 0)
        <div class = "media_pool_row warning">
            <label>{{__('delete')}} {{count($_mediaToDelete)}} {{__('selected media')}}</label>
            <button wire:click="deleteMedia()" class = "management_button">{{__('delete')}}</button>
        </div>
        @endif
    </div>

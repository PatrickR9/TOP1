<div class = "management_block">
@if(isset($organisations))
    @if(isset($selectedId) && ($selectedId === 'new'))
    <form wire:submit="saveData" action = "" method = "post">
        <div class = "management_edit_block">
            <p class = "management_edit_block_title"><strong>Neuer Datensatz</strong></p>
            <div class = "management_edit_container">
            @foreach($editFields as $dataField => $fieldValues)
                @if($dataField !== 'id')
                <div class = "management_edit_block_cell">
                    @switch($fieldValues['tag'])
                    @case('input')
                        @if(in_array($dataField, ['logo', 'logo_for_light_bg', 'logo_for_dark_bg']))
                        <label class = "management_edit_block_top_label">{!!$fieldValues['label']!!}</label>
                        @else
                        <label class = "management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                        @endif
                        <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @break;
                    @endswitch
                </div>
                @endif
            @endforeach
            </div>
            <div class = "management_edit_buttons">
                <button type = "button">cancel</button>
                <button type = "submit">insert</button>
            </div>
        </div>
    </form>
    @php
    unset($selectedId);
    @endphp
    @endif

    <div class = "management_list">
        <div class = "management_head_row">
            <div class = "management_head_cell management_small_cell">
                <form wire:submit="edit" action = "">
                    <button type = "submit" class = "easy_button easy_small_button fa fa-plus"></button>
                </form>
            </div>
        @foreach($listFields as $field => $label)
            <div class = "management_head_cell">
                {{$label}}
            </div>
        @endforeach
            <div class = "management_head_cell"></div>
        </div>

        @foreach($organisations as $organisation)
        <div class = "management_body_row">
            @if(isset($selectedId))
            <div class = "management_body_cell management_small_cell" colspan = "7">
                @foreach($organisation as $dataField => $dataValue)
                    @if(isset($editFields[$dataField]))
                    <label class = "">{!!$editFields[$dataField]['label']!!}</label>
                    @switch($editFields[$dataField]['tag'])
                    @case('input')
                    <input {!!$editFields[$dataField]['attribs']!!} wire:model={{$dataField}}>
                    @break;
                    @endswitch
                    @endif
                @endforeach
            </div>
            @else
            <div class = "management_body_cell management_small_cell">
                <form wire:submit="edit({{$organisation->id}})" action = "">
                    <button class = "fa fa-pencil"></button>
                </form>
            </div>
            @foreach($listFields as $field => $label)
            <div class = "management_body_cell">
                {{$organisation->$field}}
            </div>
            @endforeach
            @endif
        </div>
        @endforeach
    </div>
@endif
</div>
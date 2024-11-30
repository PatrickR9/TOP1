<div class = "management_block">
@if(isset($editorials))
    @if(isset($idInsert))
    <form wire:submit="insert" action = "" method = "post">
        <div class = "management_edit_block">
            <p class = "management_edit_block_title"><strong>Neuer Datensatz</strong></p>
            <div class = "management_edit_container">
            @foreach($editFields as $dataField => $fieldValues)
                @if($dataField !== 'id')
                <div class = "management_edit_block_cell">
                    @switch($fieldValues['tag'])
                    @case('media')
                    <label class = "management_edit_block_top_label">{!!$fieldValues['label']!!}</label>
                        <div class = "management_edit_block_images">
                            <div class = "management_edit_block_image" wire:click="mediaPool()"></div>
                        </div>
                        <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @break
                    @case('input')
                        <label class = "management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                        <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @break;
                    @case('select')
                    <label class = "management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                    <select wire:model="{{$dataField}}">
                        @foreach($fieldValues['options'] as $optionData)
                            <option value = "{!!$optionData['value']!!}">{!!$optionData['text']!!}</option>
                        @endforeach
                    </select>
                    @break;
                    @endswitch
                </div>
                @endif
            @endforeach
            </div>
            <div class = "management_edit_buttons">
                <button type = "submit" class = "management_button">speichern</button>
                <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
            </div>
        </div>
    </form>
    @endif
    <div class = "management_list management_list_header">
        Zeige
        <select wire:model="showRecords" wire:change="setRecordFilter()">
            <option value = "all">alle</option>
            <option value = "notDeletedRecords">aktive</option>
            <option value = "deletedRecords">gelöschte</option>
        </select> Redaktionen
    </div>
    <table class = "management_list">
        <tr class = "management_head_row">
            <th class = "management_head_cell management_small_cell center">
                <form wire:submit="edit" action = "" class = "center">
                    <button type = "submit" class = "management_button management_small_button fa fa-plus"></button>
                </form>
            </th>
        @foreach($listFields as $field => $label)
            <th class = "management_head_cell management_head_cell_sorting" wire:click="sort('{{$field}}')">
                {{$label}}
                @if(isset($orderBy['field']) === $field)
                    <i class = "management_head_cell_sorting_icon fa fa-sort-alpha-{{$orderBy['sort']}}"></i>
                @else
                    <i class = "management_head_cell_sorting_icon fa fa-unsorted"></i>
                @endif
            </th>
        @endforeach
            <th class = "management_head_cell"><i class = "fa fa-edit"></i></th>
            <th class = "management_head_cell"><i class = "fa fa-trash-o"></i></th>
        </tr>

        @foreach($editorials as $editorial)
            @php
                $addClass = '';
                if(isset($organisation->deleted_at))
                {
                    $addClass = ' management_deleted_row';
                }
            @endphp
        <tr class = "management_body_row{{$addClass}}">
            {{-- if record delete --}}
            @if(isset($idDelete) && ($idDelete ===  $editorial->id))
            <td colspan = "7"  class = "center">
                <div class = "management_edit_container">
                <p class = "management_warning"><i class = "fa fa-warning"></i> Wollen Sie den Eintrag löschen? <i class = "fa fa-warning"></i></p>
                <form wire:submit="deleteConfirmed()" action = "">
                    <button class = "management_button">löschen</button>
                </form>
                <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
            </td>
            @else
                {{-- if record edit --}}
                @if(isset($idEdit) && ($idEdit ===  $editorial->id))
                <td class = "management_body_cell no_padding" colspan = "7">
                    <div class = "management_edit_block">
                        <h3 class = "management_edit_block_title"><strong>Bearbeitung - {!! $editorial->title !!}</strong></h3>
                        <form action = "" wire:submit="update({{$idEdit}})">
                            <div class = "management_edit_container">
                            @foreach($editorial as $dataField => $dataValue)
                                @if(isset($editFields[$dataField]) && ($dataField !== 'id'))
                                <div class = "management_edit_block_cell">
                                    @switch($editFields[$dataField]['tag'])
                                    @case('input')
                                        @if(in_array($dataField, ['logo', 'logo_for_light_bg', 'logo_for_dark_bg']))
                                        <div class = "management_edit_img_label">
                                            <label class = "management_edit_block_top_label">{!!$editFields[$dataField]['label']!!}</label>
                                            @if(isset($dataValue))
                                            <img class = "management_img_small_preview" src = "{{route('image.show', ['imageName' => $dataValue, 'assign' => 'editorials', 'id' => $editorial->id])}}">
                                            @endif
                                        </div>
                                        @else
                                        <label class = "management_edit_block_top_over_label">{!!$editFields[$dataField]['label']!!}</label>
                                        @endif
                                    <input {!!$editFields[$dataField]['attribs']!!} wire:model="{{$dataField}}Edit">
                                    @break;
                                    @endswitch
                                </div>
                                @endif
                            @endforeach
                            </div>
                            <div class = "management_edit_buttons">
                                <button type = "submit" class = "management_button" >speichern</button>
                                <button type = "button" class = "management_button management_small_button fa fa-repeat" wire:click="edit({{$idEdit}})"></button>
                                <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
                            </div>
                        </form>
                    </div>
                </td>
                @else
                <td class = "management_body_cell management_small_cell center">
                    <form wire:submit="edit({{$editorial->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-pencil"></button>
                    </form>
                </td>
                @foreach($listFields as $dataField => $label)
                <td class = "management_body_cell">
                    @switch($dataField)
                        @case('logo')
                        @case('logo_for_light_bg')
                        @case('logo_for_dark_bg')
                            @if(isset($editorial->$field))
                            <img class = "" src = "{{route('image.show', ['imageName' => $editorial->$dataField])}}">
                            @endif
                        @break;
                        @case('organisation_id')
                            {{$editorial->organisation_title}}
                        @break;
                        @default
                        {{$editorial->$dataField}}
                        @break;
                    @endswitch
                </td>
                @endforeach
                <td class = "center">
                    <a href = "/editorial/{{$editorial->id}}">
                        <button type = "button" class = "management_button management_small_button fa fa-edit"></button>
                    </a>
                </td>
                <td class = "center">
                    @if(isset($editorial->deleted_at))
                    <form wire:submit="undelete({{$editorial->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-undo"></button>
                    </form>
                    @else
                    <form wire:submit="delete({{$editorial->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-trash-o"></button>
                    </form>
                    @endif
                </td>
                @endif
                {{-- end of record edit --}}
            @endif
            {{-- end of record delete --}}
        </tr>
        @endforeach
    </table>
    <nav class = "management_list management_pagination_block">
        <div class = "pagination_cell">
            <span class = "pagination_select">
                <select wire:model="rowPerPage" wire:change = "setRowPerPage()">
                    <option value = "5">5</option>
                @for($i = 25; $i <= 100; $i+=25)
                    <option value = "{{$i}}">{{$i}}</option>
                @endfor
                </select>
            </span>
            Zeilen pro Seite
        </div>
        <div class = "pagination_cell">
            Zeilen {{$firstRecord}} - {{$lastRecord}} aus {{$countOfRecords}}
        </div>
        <div class = "pagination_cell">
            Seite
            <span class = "pagination_select">
                <select wire:model="currentPage" wire:change = "setPagination()">
                @for($i = 1; $i <= $countOfSites; $i++)
                    <option value = "{{$i}}">{{$i}}</option>
                @endfor
                </select>
            </span>
            aus {{$countOfSites}}
        </div>
</nav>
@endif
</div>
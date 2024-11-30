<div class = "management_block">
@if(isset($organisations))
    @if(isset($idInsert))
    <form wire:submit="insert" action = "" method = "post">
        <div class = "management_edit_block management_edit_block_padding">
            <p class = "management_edit_block_title"><strong>Neuer Datensatz</strong></p>
            <div class = "management_edit_container">
            @foreach($editFields as $dataField => $fieldValues)
                @if($dataField !== 'id')
                <div class = "management_edit_block_cell">
                    @switch($fieldValues['tag'])
                    @case('input')
                        <label class = "management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                        <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @break;
                    @case('media')
                        <label class = "management_edit_block_top_label">{!!$fieldValues['label']!!}</label>
                        <div class = "management_edit_block_images">
                            <div class = "management_edit_block_image" wire:click="mediaPool()"></div>
                        </div>
                        <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
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
        </select> Verbände
    </div>
    <table class = "management_list">
        <tr class = "management_head_row">
            <th class = "management_head_cell management_small_cell center">
                <form wire:submit="edit" action = "" class = "center">
                    <button type = "submit" class = "management_button management_small_button fa fa-plus"></button>
                </form>
            </th>
        @foreach($listFields as $field => $label)
            <th class = "management_head_cell management_head_cell_sorting">
                @php $filterField = $field.'Filter'; @endphp
                @if(isset($$filterField))
                    @if($$filterField === '')
                    <i class = "management_head_cell_filter_icon fa fa-filter" onclick = "this.nextElementSibling.classList.toggle('management_filter_active')"></i>
                    @else
                    <i class = "management_head_cell_filter_icon filtered fa fa-filter" onclick = "this.nextElementSibling.classList.toggle('management_filter_active')"></i>
                    @endif
                    @if($filterField === 'team_nameFilter')
                    <div class = "management_head_cell_filter_block">
                        <button type = "button" class = "management_button management_small_button warning fa fa-close" wire:click="clearRecordFilter('{{$filterField}}')"></button>
                        <input type = "text" wire:model="team_nameFilter" list="team_name_datalist" wire:change="setRecordFilter()">
                        <datalist id="team_name_datalist">
                        @foreach($teamOptions as $optionValue => $optionLabel)
                            <option value = "{{$optionLabel}}">{{$optionLabel}}</option>
                        @endforeach
                        </datalist>
                    </div>
                    @endif
                @endif
                {{$label}}
                @if(isset($orderBy['field']) && ($orderBy['field'] === $field))
                    <i class = "management_head_cell_sorting_icon management_head_cell_sorting_icon_right fa fa-sort-alpha-{{$orderBy['sort']}}" wire:click="sort('{{$field}}')"></i>
                @else
                    <i class = "management_head_cell_sorting_icon management_head_cell_sorting_icon_right fa fa-unsorted" wire:click="sort('{{$field}}')"></i>
                @endif
            </th>
        @endforeach
            <th class = "management_head_cell"><i class = "fa fa-edit"></i></th>
            <th class = "management_head_cell"><i class = "fa fa-trash-o"></i></th>
        </tr>

        @foreach($organisations as $organisation)
        @php
            $addClass = '';
            if(isset($organisation->deleted_at))
            {
                $addClass = ' management_deleted_row';
            }
        @endphp
        <tr class = "management_body_row{{$addClass}}">
            {{-- if record delete --}}
            @if(isset($idDelete) && ($idDelete ===  $organisation->id))
            <td colspan = "9"  class = "center">
                <div class = "management_edit_container">
                <p class = "management_warning"><i class = "fa fa-warning"></i> Wollen Sie den Eintrag löschen? <i class = "fa fa-warning"></i></p>
                <form wire:submit="deleteConfirmed()" action = "">
                    <button class = "management_button warning">löschen</button>
                </form>
                <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
            </td>
            @else
                {{-- if record edit --}}
                @if(isset($idEdit) && ($idEdit ===  $organisation->id))
                <td class = "management_body_cell no_padding" colspan = "9">
                    <div class = "management_edit_block">
                        <h3 class = "management_edit_block_title"><strong>Bearbeitung - {!! $organisation->title !!}</strong></h3>
                        <form action = "" wire:submit="update({{$idEdit}})">
                            <div class = "management_edit_container">
                            @foreach($organisation as $dataField => $dataValue)
                                @if(isset($editFields[$dataField]) && ($dataField !== 'id'))
                                <div class = "management_edit_block_cell">
                                    @switch($editFields[$dataField]['tag'])
                                        @case('input')
                                        <label class = "management_edit_block_top_over_label">{!!$editFields[$dataField]['label']!!}</label>
                                        <input {!!$editFields[$dataField]['attribs']!!} wire:model="{{$dataField}}Edit">
                                    @break;
                                    @case('media')
                                        @php
                                            $currentEditField = $dataField.'Edit';
                                            $mediaSrc = $$currentEditField;
                                            dump(Storage::path('protected/'.$organisation->id).$$currentEditField);
                                        @endphp
                                        <label class = "management_edit_block_top_label">{!!$editFields[$dataField]['label']!!}</label>
                                        <div class = "management_edit_block_images">
                                            <div class = "management_edit_block_image" wire:click="mediaPool('{{$dataField}}Edit')">
                                                @if($dataValue === '')
                                                <i class = "fa fa-image"></i>
                                                @else
                                                <p>{{$dataField}}:---</p>
                                                @endif
                                                <input {!!$editFields[$dataField]['attribs']!!} wire:model="{{$dataField}}Edit">
                                            </div>
                                        </div>
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
                    <form wire:submit="edit({{$organisation->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-pencil"></button>
                    </form>
                </td>
                @foreach($listFields as $dataField => $label)
                <td class = "management_body_cell">
                    @if(in_array($dataField, ['logo', 'logo_for_light_bg', 'logo_for_dark_bg']) && isset($organisation->$field))
                    <img class = "" src = "{{route('image.show', ['imageName' => $organisation->$dataField])}}"
                    @elseif(isset($organisation->$dataField))
                    {{$organisation->$dataField}}
                    @endif
                </td>
                @endforeach
                <td class = "center">
                    <a href = "/organisation/{{$organisation->id}}">
                        <button type = "button" class = "management_button management_small_button fa fa-edit"></button>
                    </a>
                </td>
                <td class = "center">
                    @if(isset($organisation->deleted_at))
                    <form wire:submit="undelete({{$organisation->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-undo"></button>
                    </form>
                    @else
                    <form wire:submit="delete({{$organisation->id}})" action = "">
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
<div class = "management_block">
@if(isset($viewData['contentList']))
    @if(isset($idInsert))
        @include('livewire.d-editor.content_insert');
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

        @foreach($contents as $content)
        @php
            $addClass = '';
            if(isset($content->deleted_at))
            {
                $addClass = ' management_deleted_row';
            }
        @endphp
        <tr class = "management_body_row{{$addClass}}">
            {{-- if record delete --}}
            @if(isset($idDelete) && ($idDelete ===  $content->id))
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
                @if(isset($idEdit) && ($idEdit ===  $content->id))
                <td class = "management_body_cell no_padding" colspan = "9">
                    <div class = "management_edit_block">
                        <h3 class = "management_edit_block_title"><strong>Bearbeitung - {!! $content->title !!}</strong></h3>
                        <form action = "" wire:submit="update({{$idEdit}})">
                            <div class = "management_edit_container">
                            @foreach($content as $dataField => $dataValue)
                                @if(isset($editFields[$dataField]) && ($dataField !== 'id'))
                                <div class = "management_edit_block_cell">
                                    @switch($editFields[$dataField]['tag'])
                                    @case('input')
                                        @if(in_array($dataField, ['logo', 'logo_for_light_bg', 'logo_for_dark_bg']))
                                        <div class = "management_edit_img_label">
                                            <label class = "management_edit_block_top_label">{!!$editFields[$dataField]['label']!!}</label>
                                            @if(isset($dataValue) && ($dataValue !== ''))
                                            <img class = "management_img_small_preview" src = "{{route('image.show', ['imageName' => $dataValue, 'assign' => 'contents', 'id' => $content->id])}}">
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
                    <form wire:submit="edit({{$content->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-pencil"></button>
                    </form>
                </td>
                @foreach($listFields as $dataField => $label)
                <td class = "management_body_cell">
                    @if(in_array($dataField, ['logo', 'logo_for_light_bg', 'logo_for_dark_bg']) && isset($content->$field))
                    <img class = "" src = "{{route('image.show', ['imageName' => $content->$dataField])}}"
                    @elseif(isset($content->$dataField))
                    {{$content->$dataField}}
                    @endif
                </td>
                @endforeach
                <td class = "center">
                    <a href = "/content/{{$content->id}}">
                        <button type = "button" class = "management_button management_small_button fa fa-edit"></button>
                    </a>
                </td>
                <td class = "center">
                    @if(isset($content->deleted_at))
                    <form wire:submit="undelete({{$content->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-undo"></button>
                    </form>
                    @else
                    <form wire:submit="delete({{$content->id}})" action = "">
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
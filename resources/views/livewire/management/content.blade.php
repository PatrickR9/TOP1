<div class = "management_block">
@if(isset($contents))
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
                    @case('select')
                        <label class = "management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                        <select {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
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
    <div class = "management_box management_list_header">
        <div class = "management_list_header_left">
            Zeige
            <select wire:model="showRecords" wire:change="setRecordFilter()">
                <option value = "all">alle</option>
                <option value = "notDeletedRecords">aktive</option>
                <option value = "deletedRecords">gelöschte</option>
            </select> Einheiten
        </div>
        <div class = "management_list_header_right">
            <form wire:submit="edit" action = "">
                <button type = "submit" class = "management_button button_blue">Einheit erstellen</button>
            </form>
        </div>
    </div>
    <div class = "management_box management_list_content">
        <table class = "management_list">
            <tr class = "management_head_row">
            @foreach($listFields as $field => $label)
                <th class = "management_head_cell management_head_cell_sorting">
                    <div class = "management_head_cell_content">
                        <span>{{$label}}</span>
                        <div class = "management_head_cell_filters">
                        @php $filterField = $field.'Filter'; @endphp
                        @if(isset($orderBy['field']) && ($orderBy['field'] === $field))
                            <i class = "management_head_cell_sorting_icon management_head_cell_sorting_icon_right fa fa-sort-alpha-{{$orderBy['sort']}}" wire:click="sort('{{$field}}')"></i>
                        @else
                            <i class = "management_head_cell_sorting_icon management_head_cell_sorting_icon_right fa fa-unsorted" wire:click="sort('{{$field}}')"></i>
                        @endif
                        @if(isset($$filterField))
                            @if($$filterField === '')
                            <i class = "management_head_cell_filter_icon fa fa-sliders" onclick = "this.nextElementSibling.classList.toggle('management_filter_active')"></i>
                            @else
                            <i class = "management_head_cell_filter_icon filtered fa fa-sliders" onclick = "this.nextElementSibling.classList.toggle('management_filter_active')"></i>
                            @endif
                            @switch($filterField)
                                @case('editorial_titleFilter')
                                <div class = "management_head_cell_filter_block">
                                    <button type = "button" class = "management_button management_small_button warning fa fa-close" wire:click="clearRecordFilter('editorial_titleFilter')"></button>
                                    <input type = "text" wire:model="editorial_titleFilter" list="editorial_title_datalist" wire:change="setRecordFilter()">
                                    <datalist id="editorial_title_datalist">
                                    @foreach($editorials as $optionValues)
                                        <option value = "{{$optionValues['value']}}">{{$optionValues['text']}}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                @break;
                                @case('organisation_titleFilter')
                                <div class = "management_head_cell_filter_block">
                                    <button type = "button" class = "management_button management_small_button warning fa fa-close" wire:click="clearRecordFilter('organisation_titleFilter')"></button>
                                    <input type = "text" wire:model="organisation_titleFilter" list="organisation_title_datalist" wire:change="setRecordFilter()">
                                    <datalist id="organisation_title_datalist">
                                    @foreach($organisations as $optionValues)
                                        <option value = "{{$optionValues['text']}}">{{$optionValues['text']}}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                @break;
                                @case('titleFilter')
                                <div class = "management_head_cell_filter_block">
                                    <button type = "button" class = "management_button management_small_button warning fa fa-close" wire:click="clearRecordFilter('titleFilter')"></button>
                                    <input type = "text" wire:model="titleFilter" wire:change="setRecordFilter()">
                                </div>
                                @break;
                            @endswitch
                        @endif
                        </div>
                    </div>
                </th>
            @endforeach
                <th class = "management_head_cell"></th>
                <th class = "management_head_cell"></th>
                <th class = "management_head_cell"></th>
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
                    <form wire:submit="deleteContentConfirmed()" action = "">
                        <button class = "management_button warning">löschen</button>
                    </form>
                    <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
                </td>
                @else
                    {{-- if record edit --}}
                    @if(isset($idEdit) && ($idEdit ===  $content->id))
                    <td class = "management_body_cell no_padding" colspan = "8">
                        <div class = "management_edit_block">
                            <h3 class = "management_edit_block_title"><strong>Bearbeitung - {!! $content->title !!}</strong></h3>
                            <form action = "" wire:submit="updateContent({{$idEdit}})">
                                <div class = "management_edit_container">
                                @foreach($content as $dataField => $dataValue)
                                    @if(isset($editFields[$dataField]) && ($dataField !== 'id'))
                                    <div class = "management_edit_block_cell">
                                        @switch($editFields[$dataField]['tag'])
                                        @case('input')
                                        <label class = "management_edit_block_top_over_label">{!!$editFields[$dataField]['label']!!}</label>
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
                    @foreach($listFields as $dataField => $label)
                    <td class = "management_body_cell">
                        {{$content->$dataField}}
                    </td>
                    @endforeach
                    <td class = "center">
                        <a href = "/content/{{$content->id}}/content">
                            <button type = "button" class = "management_button management_small_button fa fa-pencil"></button>
                        </a>
                    </td>
                    <td class = "center">
                        <a href = "/content/{{$content->id}}/settings">
                            <button type = "button" class = "management_button management_small_button fa fa-gear"></button>
                        </a>
                    </td>
                    <td class = "center">
                        @if(isset($content->deleted_at))
                        <form wire:submit="undeleteContent({{$content->id}})" action = "">
                            <button class = "management_button management_small_button fa fa-undo"></button>
                        </form>
                        @else
                        <form wire:submit="deleteContent({{$content->id}})" action = "">
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
    </div>
    <nav class = "management_box manamgement_list_footer">
        <div class = "management_pagination_block">
            <div class = "pagination_cell">
                <span class = "pagination_select">
                    <select wire:model="rowPerPage" wire:change = "setRowPerPage()">
                        <option value = "5">5</option>
                    @for($i = 25; $i <= 100; $i+=25)
                        <option value = "{{$i}}">{{$i}}</option>
                    @endfor
                    </select>
                </span>
                <span>Zeilen pro Seite</span>
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
                <span>aus {{$countOfSites}}</span>
            </div>
        </div>
    </nav>
@endif
</div>
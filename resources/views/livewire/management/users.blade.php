<div class = "management_block">
    @if(isset($userList) && isset($userList[0]))
    <table class = "management_list">
        <thead>
        <tr class = "management_head_row">
            @foreach($listFields as $field => $fieldAttribs)
                @if($field === 'id')
                <th class = "management_body_cell management_body_cell_small">
                    {{$fieldAttribs['label']}}
                </th>
                @else
                <th class = "management_head_cell management_head_cell_sorting">
                    @php $filterField = $field.'Filter'; @endphp
                    @if(isset($$filterField))
                        @if($$filterField === '')
                        <i class = "management_head_cell_filter_icon fa fa-filter" onclick = "this.nextElementSibling.classList.toggle('management_filter_active')"></i>
                        @else
                        <i class = "management_head_cell_filter_icon filtered fa fa-filter" onclick = "this.nextElementSibling.classList.toggle('management_filter_active')"></i>
                        @endif
                        @if($filterField === '*****team_nameFilter')
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
                    {{$fieldAttribs['label']}}
                    @if(isset($orderBy['field']) && ($orderBy['field'] === $field))
                        <i class = "management_head_cell_sorting_icon management_head_cell_sorting_icon_right fa fa-sort-alpha-{{$orderBy['sort']}}" wire:click="sort('{{$field}}')"></i>
                    @else
                        <i class = "management_head_cell_sorting_icon management_head_cell_sorting_icon_right fa fa-unsorted" wire:click="sort('{{$field}}')"></i>
                    @endif
                </th>
                @endif
            @endforeach
                <th class = "management_head_cell"><i class = "fa fa-edit"></i></th>
                <th class = "management_head_cell"><i class = "fa fa-trash-o"></i></th>
            </tr>
        </thead>
        <tbody>
        @foreach($userList as $userRow)
            @php
            $addClass = '';
            if(isset($userRow->deleted_at))
            {
                $addClass = ' management_deleted_row';
            }
            @endphp
            <tr class = "management_body_row{{$addClass}}">
            {{-- if record delete --}}
            @if(isset($idDelete) && ($idDelete ===  $userRow->id))
            <td colspan = "9"  class = "center">
                <div class = "management_edit_container">
                <p class = "management_warning"><i class = "fa fa-warning"></i> Wollen Sie den Eintrag löschen? <i class = "fa fa-warning"></i></p>
                <form wire:submit="deleteConfirmed()" action = "">
                    <button class = "management_button warning">löschen</button>
                </form>
                <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
            </td>
            @else
                @foreach($listFields as $dataField => $label)
                @if($dataField === 'id')
                <td class = "management_body_cell management_body_cell_small">
                @else
                <td class = "management_body_cell">
                @endif
                    @if($dataField === 'team_name')
                        @php $divider = ''; @endphp
                        @foreach($userRow->ownedTeams as $userTeam)
                            {!!$divider.$userTeam->name!!}
                            @php $divider = ',<br>'; @endphp
                        @endforeach
                    @elseif($dataField === 'user_role')
                        @foreach($userRow->user2roles as $user2role)
                            {{ $user2role->userrole->name }}
                            @if(!$loop->last)
                                ,<br>
                            @endif
                        @endforeach
                    @elseif(isset($userRow->$dataField))
                        {{$userRow->$dataField}}
                    @endif
                </td>
                @endforeach
                <td class = "center">
                    <a href = "/user/{{$userRow->id}}">
                        <button type = "button" class = "management_button management_small_button fa fa-edit"></button>
                    </a>
                </td>
                <td class = "center">
                    @if(isset($userRow->deleted_at))
                    <form wire:submit="undelete({{$userRow->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-undo"></button>
                    </form>
                    @else
                    <form wire:submit="delete({{$userRow->id}})" action = "">
                        <button class = "management_button management_small_button fa fa-trash-o"></button>
                    </form>
                    @endif
                </td>
            @endif
            {{-- end of record delete --}}
            </tr>            
        @endforeach
        </tbody>
    </table>
    @endif
</div>

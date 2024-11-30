<div class = "management_edit_overview">
    <table class = "management_edit_overview_table">
        <thead>
            <tr>
                <th colspan = "2"><div class = "management_edit_overview_table_title">Benutzer</div></th>
                <th class = "pseudo_cell"><button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click="selectTab('user')"><button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentUser as $field => $value)
            <tr>
                <td class = "management_edit_overview_field">{{$field}}</td>
                <td class = "management_edit_overview_value" colspan = "2">{{$value}}</td>
            </tr>
        @endforeach
            <tr class = "management_edit_overview_cell_row">
                <td></td>
                <td></td>
                <td class = "pseudo_cell"></td>
            </tr>
        </tbody>
    </table>
    <table class = "management_edit_overview_table">
        <thead>
            <tr>
                <th colspan = "2"><div class = "management_edit_overview_table_title">Teams</div></th>
                <th>Status</th>
                <th class = "pseudo_cell"><i class = "fa fa-pencil"></i></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentUserTeams as $currentUserTeam)
            <tr class = "management_edit_overview_cell_row">
                <td class = "management_edit_overview_id">{{$currentUserTeam['id']}}</td>
                <td class = "management_edit_overview_title">{{$currentUserTeam['name']}}</td>
                <td class = "management_edit_overview_title">
                @if(isset($currentUserTeam['membership']))
                    {{$currentUserTeam['membership']['role']}}
                @else
                    Besitzer
                @endif
                </td>
                <td class = "pseudo_cell"><button type = "button" class = "management_button management_small_button fa fa-pencil"><button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table class = "management_edit_overview_table">
        <thead>
            <tr>
                <th colspan = "2"><div class = "management_edit_overview_table_title">Verbände</div></th>
                <th>Team</th>
                <th class = "pseudo_cell"><i class = "fa fa-pencil"></i></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentUserOrganisations as $currentUserOrganisation)
            <tr class = "management_edit_overview_cell_row">
                <td class = "management_edit_overview_id">{{$currentUserOrganisation['id']}}</td>
                <td class = "management_edit_overview_title">{{$currentUserOrganisation['title']}}</td>
                <td class = "management_edit_overview_title">
                @if( isset($currentUserTeamData[$currentUserOrganisation['team_id']]) && isset($currentUserTeamData[$currentUserOrganisation['team_id']]->membership))
                    {{$currentUserTeamData[$currentUserOrganisation['team_id']]->name}}
                @else
                    Besitzer
                @endif
                </td>
                <td class = "pseudo_cell"><button type = "button" class = "management_button management_small_button fa fa-pencil" ><button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table class = "management_edit_overview_table">
        <thead>
            <tr>
                <th colspan = "2"><div class = "management_edit_overview_table_title">Benutzerrollen</div></th>
                <th class = "pseudo_cell"><button type = "button" class = "management_button management_small_button fa fa-pencil" wire:click="selectTab('userroles')"><button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentUserUserRoles as $currentUserUserRole)
            <tr>
                <td class = "management_edit_overview_id">{{$currentUserUserRole['id']}}</td>
                <td class = "management_edit_overview_title" colspan = "2">{{$currentUserUserRole['name']}}</td>
            </tr>
        @endforeach
            <tr class = "management_edit_overview_cell_row">
                <td></td>
                <td></td>
                <td class = "pseudo_cell"></td>
            </tr>
        </tbody>
    </table>
    <table class = "management_edit_overview_table">
        <thead>
            <tr>
                <th colspan = "2"><div class = "management_edit_overview_table_title">Redaktionen</div></th>
                <th class = "pseudo_cell"><button type = "button" class = "management_button management_small_button fa fa-pencil"><button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentUserEditorials as $currentUserEditorial)
            <tr>
                <td class = "management_edit_overview_id">{{$currentUserEditorial['id']}}</td>
                <td class = "management_edit_overview_title" colspan = "2">{{$currentUserEditorial['title']}}</td>
            </tr>
        @endforeach
            <tr class = "management_edit_overview_cell_row">
                <td></td>
                <td></td>
                <td class = "pseudo_cell"></td>
            </tr>
        </tbody>
    </table>
</div>
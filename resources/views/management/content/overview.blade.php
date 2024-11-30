<div class = "management_edit_overview">
    <table class = "management_edit_overview_table">
        <thead>
            <tr>
                <th colspan = "2"><div class = "management_edit_overview_table_title">Verband</div></th>
                <th class = "pseudo_cell"><button type = "button" class = "management_button_small_button fa fa-pencil" wire:click="selectTab('organisation')"><button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentOrganisation as $field => $value)
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
                <th colspan = "2"><div class = "management_edit_overview_table_title">Redaktionen</div></th>
                <th class = "pseudo_cell"><button type = "button" class = "management_button_small_button fa fa-pencil" wire:click="selectTab('editorial')"><button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($currentOrganisationEditorials as $currentOrganisationEditorial)
            <tr class = "management_edit_overview_cell_row">
                <td class = "management_edit_overview_id">{{$currentOrganisationEditorial->id}}</td>
                <td class = "management_edit_overview_title" colspan = "2">{{$currentOrganisationEditorial->title}}</td>
            </tr>
        @endforeach
            <tr class = "management_edit_overview_cell_row">
                <td></td>
                <td></td>
                <td class = "pseudo_cell"></td>
            </tr>
        </tbody>
    </div>
</div>
    <form wire:submit="insert" action = "" method = "post">
        <div class = "management_edit_block management_edit_block_padding">
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
                <button type = "submit" class = "management_button">speichern</button>
                <button type = "button" class = "management_button" wire:click="cancel">abbrechen</button>
            </div>
        </div>
    </form>

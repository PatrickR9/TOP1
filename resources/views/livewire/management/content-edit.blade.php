<div class="management_block management_block_bg_alternate">
    <form id="{{$formId}}" action="">
        <div class="management_edit_container">
            @foreach($editFields as $dataField => $fieldValues)
            @if(isset($fieldValues['hidden']))
            <input type="hidden" wire:model="{{$dataField}}">
            @else
            <div class="management_edit_block_cell">
                @switch($fieldValues['tag'])
                @case('select')
                <label class="management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                <select {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @foreach($fieldValues['options'] as $optionData)
                    <option value="{!!$optionData['value']!!}">{!!$optionData['text']!!}</option>
                    @endforeach
                </select>
                @break;
                @endswitch
            </div>
            @endif
            @endforeach
        </div>
        <div class="content_creation_outer_div">
            <div class="content_creation_div">
                @if($id === 'new')
                <h2>Eintrag erstellen</h2>
                <div class="input_group_content_title">
                    <label class="content-entry-label">Neuen Titel hinzufügen</label>
                    <input type="text" class="entry-title" wire:model="title" />
                </div>
                <div class="btn_container_content">
                    <button type = "button" class="cancel_btn_content" wire:click="toList()">Abbrechen</button>
                    <button type = "button" class="create_btn_content" wire:click="saveAndNext()">Erstellen und weiter</button>
                </div>
                @else
                <h2>Eintrag bearbeiten</h2>
                    <label class = "content-entry-label">Beitragstyp</label>
                    <select class="entry-type" wire:model="type">
                        <option value = "einheit">Einheit</option>
                        <option value = "thema">Thema</option>
                        <option value = "konzept">Konzept</option>
                        <option value = "element" disabled>Element</option>
                    </select>
                    <label class="content-entry-label">Titel</label>
                    <input type="text" class="entry-title" wire:model="title" />
                </div>
                <div class="btn_container_content">
                    <button type = "button" class="cancel_btn_content" wire:click="toList()">Abbrechen</button>
                    <button type = "button" class="create_btn_content" wire:click="saveAndNext()">Speichern und weiter</button>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>
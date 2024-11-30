<div class="management_block">
    @include('d_editor.managementtopblock')
    <form id="{{$formId}}" action="">
        <div class="management_edit_block management_edit_block_padding">
            <p class="management_edit_block_title"><strong>Metadaten</strong></p>
            <div class="management_edit_container">
                @foreach($editFields as $dataField => $fieldValues)
                <div class="management_edit_block_cell">
                    @switch($fieldValues['tag'])
                    @case('media')
                    <label class="management_edit_block_top_label">{!!$fieldValues['label']!!}</label>
                    <div class="management_edit_block_images">
                        <div class="management_edit_block_image" wire:click="mediaPool()"></div>
                    </div>
                    <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @break
                    @case('input')
                    <label class="management_edit_block_top_over_label">{!!$fieldValues['label']!!}</label>
                    <input {!!$fieldValues['attribs']!!} wire:model={{$dataField}}>
                    @break;
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
                @endforeach
            </div>
        </div>
    </form>
</div>
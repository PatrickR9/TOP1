<div class="d_editor_table d_editor_properties"><i class="fa fa-image" onclick = "dEditorProperties(this.parentNode)"></i><i class="fa fa-close" onclick = "this.parentNode.classList.remove('opened');"></i>
    <div class="block_properties fwrap">
        <div class="block_property block_table fwrap">
            <div class="block_property_cell w100">
                <button class = "management_button management_button_bordered" class = "" wire:click="dEditorMediaPool('img','{{str_replace('_content_', '_figure_image_', $siteBlock->editor_id)}}', ['image/jpeg', 'image/png', 'application/svg+xml'])">Bild wählen</button>
            </div>
                <div class="block_property_cell w100">
                    <input id = "{{$siteBlock->editor_id}}_image_caption" type = "checkbox" {{$siteBlock->editor_attribs['data-image-caption']}}><label class="management_edit_block_top_label">Beschriftung</label>
                <textarea id="{{$siteBlock->editor_id}}_image_caption_text">{{$siteBlock->editor_attribs['data-image-caption-text']}}</textarea>
            </div>
        </div>
        <div class="block_property_row w100">
            <button type="button" class="management_button management_button_bordered" wire:click="setContentEditorAttribs('{{$siteBlock->editor_id}}', ['data-image-caption', 'data-image-caption-text'], [{{$siteBlock->editor_id}}_image_caption.checked, {{$siteBlock->editor_id}}_image_caption_text.value])">übernehmen</button>
        </div>
    </div>
</div>
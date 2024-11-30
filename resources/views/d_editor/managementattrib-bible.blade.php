<div class="d_editor_table d_editor_properties">
    <i class="fa fa-book" onclick = "dEditorProperties(this.parentNode)"></i>
    <i class="fa fa-close" onclick = "this.parentNode.classList.remove('opened');"></i>
    <div class="block_properties fwrap">
        <div class="block_property block_table fwrap">
            <div class="block_property_cell w100">
                <button class = "management_button management_button_bordered" class = "" wire:click="dEditorBible('{{$siteBlock->editor_id}}_bible')">Bibelstelle suchen</button>
            </div>
            <div class="block_property_cell w100">
                <input id = "{{$siteBlock->editor_id}}_bible" type = "text" {{$siteBlock->editor_attribs['data-bible-values']}}>
                <label class="management_edit_block_top_label">Bibelstellen</label>
                <span>Bibelstellen</span>
            </div>
        </div>
        <div class="block_property_row w100">
            <button type="button" class="management_button management_button_bordered" wire:click="setContentEditorAttribs('{{$siteBlock->editor_id}}', ['data-image-caption', 'data-image-caption-text'], [{{$siteBlock->editor_id}}_image_caption.checked, {{$siteBlock->editor_id}}_image_caption_text.value])">übernehmen</button>
        </div>
    </div>
</div>
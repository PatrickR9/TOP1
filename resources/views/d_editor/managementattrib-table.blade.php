<div class="d_editor_table d_editor_properties"><i class="fa fa-table" onclick = "dEditorProperties(this.parentNode)"></i><i class="fa fa-close" onclick = "this.parentNode.classList.remove('opened');"></i>
    <div class="block_properties fwrap">
        <div class="block_property block_table fwrap">
            <div class="block_property_cell w50">
                <label class="management_edit_block_top_over_label">Spalten</label>
                <input id="{{$siteBlock->editor_id}}_table_col" type="number" min="1" max="10" step="1" value="{{$siteBlock->editor_attribs['data-table-col']}}">
            </div>
            <div class="block_property_cell w50">
                <label class="management_edit_block_top_over_label">Zeilen</label>
                <input id="{{$siteBlock->editor_id}}_table_row" type="number" min="1" max="10" step="1" value="{{$siteBlock->editor_attribs['data-table-row']}}">
            </div>
            <div class="block_property_cell w100">
                <input id="{{$siteBlock->editor_id}}_table_caption" type="checkbox" {{$siteBlock->editor_attribs['data-table-caption']}}>
                <label class="management_edit_block_top_label">Caption</label>
                <textarea id="{{$siteBlock->editor_id}}_table_caption_text">{{$siteBlock->editor_attribs['data-table-caption-text']}}</textarea>
            </div>
            <div class="block_property_cell w50">
                <label class="management_edit_block_top_label">Spaltenkopf</label>
                <input id="{{$siteBlock->editor_id}}_table_col_head" type="checkbox" {{$siteBlock->editor_attribs['data-table-col-head']}}>
            </div>
            <div class="block_property_cell w50">
                <label class="management_edit_block_top_label">Zeilenkopf</label>
                <input id="{{$siteBlock->editor_id}}_table_row_head" type="checkbox" {{$siteBlock->editor_attribs['data-table-row-head']}}>
            </div>
        </div>
        <div class="block_property_row w100">
            <button type="button" class="management_button management_button_bordered" wire:click="setContentEditorAttribs('{{$siteBlock->editor_id}}', ['data-table-col', 'data-table-row', 'data-table-caption', 'data-table-caption-text', 'data-table-col-head', 'data-table-row-head'], [{{$siteBlock->editor_id}}_table_col.value, {{$siteBlock->editor_id}}_table_row.value, {{$siteBlock->editor_id}}_table_caption.checked, {{$siteBlock->editor_id}}_table_caption_text.value, {{$siteBlock->editor_id}}_table_col_head.checked, {{$siteBlock->editor_id}}_table_row_head.checked])">übernehmen</button>
        </div>
    </div>
</div>
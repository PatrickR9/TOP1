<div class = "d_property">
    <div class = "d_property_buttons">
        <button class = "button" type = "button" onclick = "siteSave()" form = "d_editor_form">speichern</button>
    </div>
    <button type = "button" class = "accordion_button accordion_button_closed" onclick = "toggleAccordion(this)">Blocks</button>
    <div class = "d_property_components accordion_block accordion_block_closed">
        <div id="dc_hx" class="d_property_component" ondragstart="aDragCopy(this, this.parentNode.className);"   ondragend="aReleaseNew()" draggable = "true" data-form = "d_property_component_form"><span>Titel</span></div>
        <div id="dc_text" class="d_property_component" ondragstart="aDragCopy(this, this.parentNode.className);" ondragend="aReleaseNew()" draggable = "true" data-form = "d_property_component_form"><span>Text</span></div>
        <div id="dc_media" class="d_property_component" ondragstart="aDragCopy(this, this.parentNode.className);" ondragend="aReleaseNew()" draggable = "true" data-form = "d_property_component_form"><span class = "fa fa-image"></span></div>
    </div>
    <button type = "button" class = "accordion_button accordion_button_closed" onclick = "toggleAccordion(this)">Eigenschaften</button>
    <div class = "d_property_controls accordion_block accordion_block_closed">
        LW - Editor properties
    </div>
</div>
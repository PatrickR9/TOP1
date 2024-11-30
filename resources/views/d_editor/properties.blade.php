<div class = "d_property">
    <span class = "d_property_label">Baukasten</span>
    @include('d_editor.blocks')


    @if(false)
    <button id = "dEditorPropertiesAccordionButton" type = "button" class = "accordion_button accordion_button_closed" onclick = "toggleAccordion(this)">Eigenschaften</button>
    <div class = "d_property_controls accordion_block accordion_block_closed" id = "block_property_box">
    @livewire('d-editor.properties', ['siteId' => $siteId, 'siteType' => $siteType])
    </div>
    <button id = "dEditorSitemapAccordionButton" type = "button" class = "accordion_button accordion_button_closed" onclick = "toggleAccordion(this)">Sitemap</button>
    <div class = "d_property_controls accordion_block accordion_block_closed">
        include('d_editor.sitemap')
    </div>
    @endif


</div>
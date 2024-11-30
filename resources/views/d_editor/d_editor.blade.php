            @if(isset($site))
            <div class = "d_editor" id="d_editor" ondragenter="aDragOver(event, this);aInsertPrepare(this);">
                @foreach($site->siteblocks as $siteBlock)
                    @php
                    $frontendAttribs = json_decode($siteBlock->attribs, true);
                    $sideBlockFrontendAttribs = '';
                    foreach($frontendAttribs as $attribName => $attribValue)
                    {
                        $sideBlockFrontendAttribs .= ' data-frontend-'.$attribName.'="'.$attribValue.'"'; 
                    }
                    $editorAttribs = json_decode($siteBlock->editor_attribs, true);
                    $sideBlockEditorAttribs = ' id="'.$siteBlock->editor_id.'"';
                    foreach($editorAttribs as $attribName => $attribValue)
                    {
                        $sideBlockEditorAttribs .= ' '.$attribName.'="'.$attribValue.'"'; 
                    }

                    if(isset($editorAttribs['data-class']))
                    {
                        $blockClass = $attribs['data-class'];
                    }
                    else
                    {
                        $blockClass = 'w100';
                    }
                    @endphp
                <div id = "{!! str_replace('_content_', '_block_', $siteBlock->editor_id) !!}" class = "d_editor_block {{$blockClass}}" ondragstart="aDrag(this);" ondragenter="aInsert(this);aSetDragged()" ondragend="aRelease()" ondrop="aRelease()" tabindex = "0" onclick = "dEditorBlockSelected(this.id)">
                    <{{$siteBlock->tag}}{!!$sideBlockEditorAttribs!!}{!!$sideBlockFrontendAttribs!!}>{!!$siteBlock->content!!}</{{$siteBlock->tag}}>
                    <div class = "d_editor_buttons">
                        <div class = "d_editor_grabber" draggable="true"><i class="fa fa-arrows"></i></div>
                        <div class = "d_editor_bars" draggable="true" onclick = ""><i class="fa fa-bars"></i></div>
                    </div>
                </div>
                @endforeach

                <div id = "d_editor_cover" ondragenter="aInsert(this);aSetDragged()" ondragend="aRelease()" ondrop="aRelease()">
                </div>
            </div>
            @else
            <div class = "warning">
                <p>Kein Zugang</p>
            </div>
            @endif
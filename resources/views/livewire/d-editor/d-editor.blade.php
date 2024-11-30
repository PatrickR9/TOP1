<div class = "d_block">
    <div class = "d_editor" id="d_editor" ondragenter="aDragOver(event, this);aInsertPrepare(this);">
    @if($blockLocked)
        <div class = "warning">
            <p>Die Seite wird von einem anderen Benutzer bearbeitet</p>
        </div>
    @else
        @if(isset($currentUsersite))
            @foreach($currentUsersite->siteBlocks as $siteBlock)
                @php
                $blockClass = [];
                $selectedProperties = [];
                $sideBlockAttribs = '';
                $sideBlockFrontendAttribs = '';
                ## FRONTEND ATTRIBS
                foreach($siteBlock->attribs as $attribName => $attribValue)
                {
                    $sideBlockFrontendAttribs .= ' data-frontend-'.$attribName.'="'.$attribValue.'"'; 
                    $selectedProperties[$attribName] = $attribValue;
                    $sideBlockAttribs .= ' '.$attribName.'='.$attribValue;
                }
                ## BACKEND ATTRIBS
                $sideBlockEditorAttribs = ' id="'.$siteBlock->editor_id.'"';
                if(isset($siteBlock->editor_attribs['data-mce-content-body']))
                {
                    if(isset($siteBlock->editor_attribs['class']))
                    {
                        $siteBlock->editor_attribs['class'] = trim('mce-content-body '.$siteBlock->editor_attribs['class']);
                    }
                    else
                    {
                        $siteBlock->editor_attribs['class'] = 'mce-content-body';
                    }
                    unset($siteBlock->editor_attribs['data-mce-content-body']);
                }
                foreach($siteBlock->editor_attribs as $attribName => $attribValue)
                {
                    $sideBlockEditorAttribs .= ' '.$attribName.'="'.$attribValue.'"';
                }
                $blockDivId = str_replace('_content_', '_block_', $siteBlock->editor_id);
                if($preparedBlockId === $blockDivId)
                {
                    $addEditorBlockClass = 'd_editor_block_to_delete ';
                }
                else
                {
                    $addEditorBlockClass = '';
                }
                @endphp
            <div id = "{{$blockDivId}}" class = "d_editor_block" ondragstart="aDrag(this);" ondragenter="aInsert(this);aSetDragged()" ondragend="aRelease()" ondrop="aRelease()" tabindex = "0" oninput = "siteBlocksChanged=true" onfocusout = "dEditorBlockUpdate(this)"{{$sideBlockAttribs}}>
                <{{$siteBlock->tag}}{!!$sideBlockEditorAttribs!!}{!!$sideBlockFrontendAttribs!!}>{!!$siteBlock->content!!}</{{$siteBlock->tag}}>
                <div class = "d_editor_buttons">
                    @if(isset($preparedBlockId) && ($preparedBlockId ===  $blockDivId))
                    <div class = "d_editor_close" wire:click="blockDelete();"><i class="fa fa-close"></i></div>
                    <div class = "d_editor_trash" wire:click="blockDelete('{{$blockDivId}}', true);"><i class="fa fa-trash-o"></i></div>
                    <div class = "d_editor_notice"><div>Block löschen?</div></div>
                    @else
                    <div class = "d_editor_grabber" draggable="true"> : : : </div>
                    @switch($siteBlock->editor_attribs['data-content-type'])
                    @case('figure')
                        @include('d_editor.managementattrib-figure')
                    @break;
                    @case('table')
                        @include('d_editor.managementattrib-table')
                        @php $classValues['border']['options']['inside'] = 'innen'; @endphp
                    @break;
                    @endswitch
                    <div class = "d_editor_trash" wire:click="blockDelete('{{$blockDivId}}');"><i class="fa fa-trash-o"></i></div>
                    <div class = "d_editor_common d_editor_properties"><i class="fa fa-ellipsis-h" onclick = "dEditorProperties(this.parentNode)"></i><i class="fa fa-close" onclick = "this.parentNode.classList.remove('opened');"></i>
                        <div class = "block_properties">
                            @foreach($classValues as $property => $propertyValues)
                                @if(count($propertyValues['options']) > 0)
                                <label>{{$propertyValues['label']}}</label>
                                <ul class = "block_property block_width">
                                    @php
                                    if(!isset($selectedProperties[$property]))
                                    {
                                        $propertyIndexes = array_keys($propertyValues['options']);
                                        $selectedProperties[$property] = $propertyValues['options'][$propertyIndexes[0]];
                                    }
                                    @endphp
                                    @foreach($propertyValues['options'] as $optionValue => $optionLabel)
                                        @if($selectedProperties[$property] === $optionValue)
                                        <li class = "block_property_row selected">
                                        @else
                                        <li class = "block_property_row" wire:click="setContentAttribs('{{$siteBlock->editor_id}}', 'data-class-{{$property}}','{{$optionValue}}')">
                                        @endif
                                            <span class = "block_{{$property}}_shown"><span class = "{{$optionValue}}"></span></span>
                                            <span class = "block_{{$property}}_label">{{$optionLabel}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            <div id = "d_editor_cover" class = "" ondragenter="aInsert(this);aSetDragged()" ondragend="aRelease()" ondrop="aRelease()"><span> - letzte Box hierher ziehen - </span></div>
            <textarea style = "width: 100%; height: 250px;" id = "currentBlockContent" class = "input_hidden" readonly></textarea>
            <input style = "width: 100%;" class = "input_hidden" readonly id = "currentEditedSiteBlockIds" wire:change="updateSessionSiteBlock(currentBlockIdToUpdate, currentBlockContent.value, currentEditedSiteBlockIds.value)">
            {{$deMsg}}
        @else
            <div class = "warning">
                <p>Sie haben keine Bearbeitungsrechte</p>
            </div>
        @endif
    @endif
    </div>
</div>
@switch($popupParams['close_button'])
    @case(null)
    @case('none')
    <div id = "d_editor_popup" class = "d_editor_popup">
    @break
@endswitch
        <div class = "d_editor_popup_content">
            {!!$popupParams['content']!!}
        </div>
    </div>

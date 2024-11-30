<div class = "management_block">
    <div class = "management_edit_block management_edit_block_padding management_check_block">
        <p class = "management_edit_block_title"><strong>Beitragsprüfung</strong></p>
        @foreach($currentContentClasses as $field => $classValue)
        <div class = "management_check_row management_check_{{$classValue}}">
            <span class = "management_check_icon"></span>
            <span class = "management_check_text">{{$currentContentLabels[$field]}}
                @if(isset($warningList[$field]['href']))
                    <a href = "/{{str_replace('#contentid#', $contentId, $warningList[$field]['href'])}}"><button class = "management_button management_button_bordered">Bearbeiten</button></a>
                @endif
            </span>
            <ul class = "management_check_list">
            @if(isset($warningList[$field][$classValue]))
                <li>
                    <span>{{$warningList[$field][$classValue]}}</span>
                </li>
            @endif
            </ul>
        </div>
        @endforeach
    </div>
</div>
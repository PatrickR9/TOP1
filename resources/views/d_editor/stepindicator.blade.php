<div class = "step_indicator step_{{$step}}">
    <div class = "step_block step_1">
        <i class = "fa fa-check-circle"></i>
        <i class = "step_indicator_circle"></i>
        @if($stepUrls['step_1'] === '')
            @if($contentId === 'new')
        <span class = "step_label step_label_{{intval($stepUrls['step_1']!=='')}}" >Eintrag erstellen</span>
            @else
        <span class = "step_label step_label_{{intval($stepUrls['step_1']!=='')}}" >Titel</span>
            @endif
        @else
        <a class = "step_label step_label_{{intval($stepUrls['step_1']!=='')}}" href = "{{$stepUrls['step_1']}}">Titel</a>
        @endif
        <span class = "step_line"></span>
    </div>
    <div class = "step_block step_2">
        <i class = "fa fa-check-circle"></i>
        <i class = "step_indicator_circle"></i>
        @if($stepUrls['step_2'] === '')
        <span class = "step_label step_label_{{intval($stepUrls['step_2']!=='')}}" >Gestaltung</span>
        @else
        <a class = "step_label step_label_{{intval($stepUrls['step_2']!=='')}}" href = "{{$stepUrls['step_2']}}">Gestaltung</a>
        @endif
        <span class = "step_line"></span>
    </div>
    <div class = "step_block step_3">
        <i class = "fa fa-check-circle"></i>
        <i class = "step_indicator_circle"></i>
        @if($stepUrls['step_3'] === '')
        <span class = "step_label step_label_{{intval($stepUrls['step_3']!=='')}}" >Materialen</span>
        @else
        <a class = "step_label step_label_{{intval($stepUrls['step_3']!=='')}}" href = "{{$stepUrls['step_3']}}">Materialen</a>
        @endif
        <span class = "step_line"></span>
    </div>
    <div class = "step_block step_4">
        <i class = "fa fa-check-circle"></i>
        <i class = "step_indicator_circle"></i>
        @if($stepUrls['step_4'] === '')
        <span class = "step_label step_label_{{intval($stepUrls['step_4']!=='')}}" >Details</span>
        @else
        <a class = "step_label step_label_{{intval($stepUrls['step_4']!=='')}}" href = "{{$stepUrls['step_4']}}">Details</a>
        @endif
        <span class = "step_line"></span>
    </div>
    <div class = "step_block step_5 step_block_last">
        <i class = "fa fa-check-circle"></i>
        <i class = "step_indicator_circle"></i>
        <span class = "step_label">Beitragsprüfung</span>
    </div>
</div>

<div class="metadata-scrollable">
    <div class = "metadata_flex_wrapper">
    Materials hier
    @foreach($metaFields as $metaField)
    <div class = "{{$metaField['css_class']}} meta_element">
        <label>{{$metaField['label']}}</label>
        @php
        $addAttribs = [];
        $addTagAttribs = '';
        $inputLengthCounter = '';
        if(isset($metaField['contribution_check']))
        {
            $contributionChecks = json_decode($metaField['contribution_check'], true);
            foreach($contributionChecks as $attribName => $attribValue)
            {
                switch($attribName)
                {
                    case 'max':
                    case 'min':
                    case 'required':
                    {
                        $addAttribs[] = $attribName.'="'.$attribValue.'"';
                        break;
                    }
                    case 'min_length':
                    case 'min_length_percent':
                    {
                        $addAttribs[] = 'oninput="this.nextElementSibling.children[0].innerText=this.value.length;"';
                        if(isset($metaInputFields['mf_'.$metaField['id']]))
                        {
                            if($attribName === 'min_length')
                            {
                                $minLength = mb_strlen($metaInputFields['mf_'.$metaField['id']][0]);
                            }
                            else
                            {
                                $minLength = ceil($contentTextLength * $attribValue / 100);
                            }
                        }
                        else
                        {
                            $minLength = 0;
                        }
                        $inputLengthCounter = '<span class = "meta_field_counter"><span class = "field_length_counter">'.$minLength.'</span>/<span class = "">'.$attribValue.'</span></span>';
                        break;
                    }
                    default:
                    {
                        break;
                    }
                }
            }
            $addTagAttribs = implode(' ', $addAttribs);
        }
        @endphp
        @foreach($metaField['typeDecoded'] as $metaCounter => $mfType)
            @if(isset($metaTextBefore[$metaCounter]))
                <span class = "">{{$metaTextBefore[$metaCounter]}}</span>
            @endif
            @switch($mfType)
            @case('date_time')
                    <input type = "date" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                    <input type = "time" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                @break;
                @case('enum')
                <select wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                    @foreach($metaField['metaFieldDataSource'] as $dataRow)
                        <option value = "{{$dataRow}}">{{$dataRow}}</option>
                    @endforeach
                </select>
                @break;
                @case('image')
                Image
                @break;
                @case('longtext')
                <textarea wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}></textarea>
                {!!$inputLengthCounter!!}
                @break;
                @case('text')
                <input type = "text" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                @break;
                @case('unsigned_integer')
                @php
                    if(!isset($contributionChecks['min']))
                    {
                        $addTagAttribs .= 'min=0';
                    }
                @endphp
                <input type = "number" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                @break;
                @default
                Unter Bearbeitung
                @break;
            @endswitch
            @if(isset($metaTextAfter[$metaCounter]))
                <span class = "">{{$metaTextAfter[$metaCounter]}}</span>
            @endif
        @endforeach
    </div>
    @endforeach
    </div>
</div>

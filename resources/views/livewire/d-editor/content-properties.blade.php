<div class="management_block">
    <div class="metadata-scrollable">
        <div>
            <h2>Metadaten hinzufügen</h2>
        </div>
        <div class="metadata_flex_wrapper">
            @foreach($metaFields as $metaField)
            <div class = "flex_cell {{$metaField['css_class']}}">
                <label class = "metadata_label">{{$metaField['label']}}</label>
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
                                        $currentLength = mb_strlen($metaInputFields['mf_'.$metaField['id']][0]);
                                        $minLength = $attribValue;
                                    }
                                    else
                                    {
                                        $currentLength = mb_strlen($metaInputFields['mf_'.$metaField['id']][0]);
                                        $minLength = ceil($contentTextLength * $attribValue / 100);
                                    }
                                }
                                else
                                {
                                    $minLength = 0;
                                }
                                $inputLengthCounter = '<span class = "meta_field_counter"><span class = "field_length_counter">'.$currentLength.'</span>/<span class = "">'.$minLength.'</span></span>';
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
                        @case('date')
                            <input type = "date" class = "input_date" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                        @break;
                        @case('time')
                            <input type = "time" class = "input_time" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                        @break;
                        @case('enum')
                        <select wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                            @foreach($metaField['metaFieldDataSource'] as $dataRow)
                                <option value = "{{$dataRow}}">{{$dataRow}}</option>
                            @endforeach
                        </select>
                        @break;
                        @case('livewire')
                            @livewire($metaField['code_to_insert'], [
                                'value' => $metaInputFields['mf_'.$metaField['id']][0], 
                                'metaFieldId' => $metaField['id']
                            ], key($metaField['id']))
                        @break;
                        @case('image')
                            @foreach($metaInputFields['mf_'.$metaField['id']] as $mediaCounter => $metaInputFieldValue)
                            <div class = "meta_img">
                                @php 
                                if(isset($mediaData) && isset($mediaData['mf_'.$metaField['id']][$mediaCounter]))
                                {
                                    $mediumData = $mediaData['mf_'.$metaField['id']][$mediaCounter];
                                }
                                else
                                {
                                    if($metaInputFieldValue === "") {
                                        $mediumData = [];
                                    }
                                    else {
                                        $mediumData = \App\Models\Mediapool::find($metaInputFieldValue)->toArray();
                                    }
                                }
                                @endphp                                    
                                @if(isset($mediumData['id']))
                                <div class="management_img_small_preview">
                                    <img src="http://dev.r-io.local/image/{{$mediumData['id']}}">
                                    <span class="meta_img_name">{{$mediumData['label']}} ({{$mediumData['filename']}})</span>
                                    <button class="btn_add_image" wire:click="metadataMediaPool('img', 'mf_{{$metaField['id']}}.{{$metaCounter}}', ['image/jpeg', 'image/png', 'application/svg+xml'])">Bild tauschen</button>
                                    <button class="btn_add_image" wire:click="metaMediaDelete('mf_{{$metaField['id']}}', {{$mediaCounter}})">Bild löschen</button>
                                    @else
                                    <button class="btn_add_image" wire:click="metadataMediaPool('img', 'mf_{{$metaField['id']}}.{{$metaCounter}}', ['image/jpeg', 'image/png', 'application/svg+xml'])">Bild hinzufügen</button>
                                    @endif
                                    <input type="hidden" id="mf_{{$metaField['id']}}.{{$metaCounter}}" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}">
                                </div>
                            </div>
                            @endforeach
                        @break;
                        @case('longtext')
                        <textarea class = "input_100" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}></textarea>
                        {!!$inputLengthCounter!!}
                        @break;
                        @case('text')
                        <textarea class = "input_100" type = "text" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}></textarea>
                        {!!$inputLengthCounter!!}
                        @break;
                        @case('unsigned_integer')
                        @php
                            if(!isset($contributionChecks['min']))
                            {
                                $addTagAttribs .= 'min=0';
                            }
                        @endphp
                        <input type = "number" class = "input_number_small" wire:model="metaInputFields.mf_{{$metaField['id']}}.{{$metaCounter}}" wire:change="metaUpdateTimer()" {!!$addTagAttribs!!}>
                        @break;
                        @default
                        {{$mfType}} Unter Bearbeitung
                        @break;
                    @endswitch
                    @if(isset($metaTextAfter[$metaCounter]))
                        <span class = "">{{$metaTextAfter[$metaCounter]}}</span>
                    @endif
                @endforeach
            </div>
            @endforeach
        </div>

        <hr>
        <div class="metadata_flex_wrapper">
            <div class="flex_cell_33 meta_element">
                <label><strong>Redaktion</strong></label>
                @livewire('metadata.autocomplete-search', ['authorId' => $authorId, 'model' => 'Editorial', 'column' => 'title', 'placeholderText' => "Redaktion wählen"])
            </div>
            <div class="flex_cell_33 meta_element">
                <label><strong>Verband</strong></label>
                @livewire('metadata.autocomplete-search', ['authorId' => $authorId, 'model' => 'Organisation', 'column' => 'title', 'placeholderText' => "Verband wählen"])
            </div>
            <div class="flex_cell_50 meta_element">
                <p>Für die Qualität des Eintrags ist die Auswahl der passenden Metadaten wichtig.</p>
                <x-confirmation-checkbox label="Ich habe die Metadaten überprüft" id="metadataChecked" />
            </div>
        </div>
    </div>
</div>
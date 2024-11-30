<?php

namespace App\Livewire\DEditor;

use Livewire\Component;
use App\Http\Controllers\Content2MetaFieldsAutosaveController;
use App\Models\Content;
use App\Models\Content2MetaField;
use App\Models\Mediapool;

class ContentProperties extends Component
{
    public $authorId;
    public $autoSaveTimeStep = 30; # 5 minutes
    public $contentId;    // from Liverwire parameter in resources\views\d_editor\index.blade.php line 21
    public $contentTextLength = 0; 
    protected $listeners = 
    [
        'applyStep4' => 'apply',
        'reloadMetaVersion' => 'reloadMetaVersion',
        'saveUpdatedValue' => 'saveUpdatedValue',
        'setSelectedMedium' => 'setSelectedMedium'
    ];
    public $mediaData = [];
    public $metaFields;
    public $metaInputFields = [];
    public $step;
    public $updateTimestamp = false;

    public function apply()
    {
        foreach($this->metaInputFields as $metaInputFieldId => $metaValue)
        {
            $metaFieldId = intval(str_replace('mf_', '', $metaInputFieldId));
            $savedMetaData = Content2MetaField::where('content_id', '=', $this->contentId)
                ->where('content_meta_field_id', '=', $metaFieldId)
                ->get();
            if(!isset($savedMetaData->id))
            {
                $savedMetaData = new Content2MetaField();
                $savedMetaData->content_id = $this->contentId;
                $savedMetaData->content_meta_field_id = $metaFieldId;
                $savedMetaData->version_type = 0;
            }
            $savedMetaData->value = json_encode($metaValue, JSON_UNESCAPED_UNICODE);
            $savedMetaData->save();
            Content2MetaFieldsAutosaveController::deleteAutosaves($this->contentId);
        }
    }
    public function metadataMediaPool($targetType, $targetId, $acceptedTypes)
    {
        $currentContent = Content::find($this->contentId);

        $this->dispatch('openPool', ['dispatch' => 'setSelectedMedium', 'source' => 'protected', 'id' => $currentContent->organisation_id, 'type' => $targetType, 'target' => $targetId, 'accepted' => $acceptedTypes]);
        $this->skipRender();
    }
    public function metaMediaDelete($metaFieldIndex, $counter)
    {
        unset($this->mediaData[$metaFieldIndex][$counter]);
        $this->metaInputFields[$metaFieldIndex][$counter] = '';
        $this->metaUpdateTimer(false);
    }
    public function metaUpdateTimer($skipRendering = true)
    {
        date_default_timezone_set('Europe/Berlin');
        $currentTime = time();
        if(($this->updateTimestamp === false) || ($this->updateTimestamp <= $currentTime))
        {
            $postValues = $this->metaInputFields;
            $postValues['contentId'] = $this->contentId;
            $metaAutosave = new Content2MetaFieldsAutosaveController();
            $metaAutosave->update($postValues);
            $this->updateTimestamp = $currentTime + $this->autoSaveTimeStep;
        }
        $this->dispatch('reRender', []);
        if($skipRendering)
        {
            $this->skipRender();
        }
    }
    public function mount()
    {
        $currentContent = Content::find($this->contentId);
        $this->authorId = $currentContent->author_id;
        $contentText = '';
        $contentDivider = '';
        foreach($currentContent->siteblocks as $siteBlock)
        {
            $contentText .= $contentDivider.trim(strip_tags($siteBlock['content']));
            $contentDivider = ' ';
        }
        $this->contentTextLength += mb_strlen($contentText);  
        $this->metaFields = Content2MetaFieldsAutosaveController::getMetaFields($this->step);
        $savedMetaData = Content2MetaFieldsAutosaveController::getSavedMetaValues($this->contentId);
        foreach($this->metaFields as &$metaField)
        {
            $metaField['typeDecoded'] = json_decode($metaField['type'], true);
            unset($metaField['type']);
            $metaField['metaFieldDataSource'] = json_decode($metaField['data_source'], true);
            unset($metaField['data_source']);
            if(isset($savedMetaData[$metaField['id']]['value']))
            {
                $savedMetaFieldValues = json_decode($savedMetaData[$metaField['id']]['value'], true);
            }
            else
            {
                $savedMetaFieldValues = [];
            }
            foreach($metaField['typeDecoded'] as $metaCounter => $metaSubFieldType)
            {
                if(isset($savedMetaFieldValues[$metaCounter]))
                {
                    if ($metaSubFieldType === 'livewire') {
                        $this->metaInputFields['mf_'.$metaField['id']][$metaCounter] = $savedMetaFieldValues;
                    }
                    else {
                        $this->metaInputFields['mf_'.$metaField['id']][$metaCounter] = $savedMetaFieldValues[$metaCounter];
                    }
                }
                else
                {
                    # if a part of content text needed
                    if(strpos($metaField['contribution_check'], '_length_percent') !== false)
                    {
                        $contributionChecks = json_decode($metaField['contribution_check'], true);
                        $minLength = intval(ceil($this->contentTextLength * $contributionChecks['min_length_percent'] / 100));
                        $this->metaInputFields['mf_'.$metaField['id']][$metaCounter] = mb_substr($contentText, 0, $minLength);
                    }
                    elseif($metaSubFieldType === 'enum')
                    {
                        $this->metaInputFields['mf_'.$metaField['id']][$metaCounter] = $metaField['metaFieldDataSource'][$metaCounter];
                    }
                    else
                    {
                        $this->metaInputFields['mf_'.$metaField['id']][$metaCounter] = '';
                    }
                }
            }
            if(isset($metaField['text_before_field']))
            {
                $metaField['metaTextBefore'] = json_decode($metaField['text_before_field'], true);
            }
            else
            {
                $metaField['metaTextBefore'] = [];
            }
            if(isset($metaField['text_after_field']))
            {
                $metaField['metaTextAfter'] = json_decode($metaField['text_after_field'], true);
            }
            else
            {
                $metaField['metaTextAfter'] = [];
            }
        }
    }
    public function render()
    {
        return view('livewire.d-editor.content-properties');
    }
    public function reloadMetaVersion($versionVars)
    {
        switch($versionVars['versionType'])
        {
            # autosave
            case 'vt2':
            {
                $savedMetaData = Content2MetaFieldsAutosaveController::getAutoSavedMetaValues($this->contentId, intval(str_replace('vn', '', $versionVars['versionNumber'])));
                break;
            }
        }
        foreach($savedMetaData as $savedMetaRow)
        {
            $savedMetaValues = json_decode($savedMetaRow['value'], true);
            foreach($savedMetaValues as $saverdMetaCounter => $savedMetaValue)
            {
                $this->metaInputFields['mf_'.$savedMetaRow['content_meta_field_id']][$saverdMetaCounter] = $savedMetaValue;
            }
        }
    }
    public function setSelectedMedium($media)
    {
        $targetIndexes = explode('.', $media['targetId']);
        $targetId = intval(str_replace('mf_', '', $targetIndexes[0]));
        if(isset($this->metaInputFields[$targetIndexes[0]]))
        {
            $this->metaInputFields[$targetIndexes[0]][0] = $media['mediumId'];
            $this->mediaData[$targetIndexes[0]] = [$media['mediumData']];
            $this->metaUpdateTimer(false);
        }
    }
    public function saveUpdatedValue($params)
    {
        if(isset($params['meta_field_id']) && isset($params['value'])) {
            $this->metaInputFields[$params['meta_field_id']][0] = strval($params['value']);
            $this->metaUpdateTimer(false);
        }
    }
    public function save()
    {
        $this->apply();
    }
    public function saveAndList()
    {
        $this->apply();
        return redirect()->to('/contents');
    }
    public function saveAndNext()
    {
        $this->apply();
        if($this->step === 3)
        {
            $route = 'content.properties';
        }
        else
        {
            $route = 'content.contributioncheck';   
        }
        return redirect()->route($route, ['id' => $this->contentId]);
    }
}

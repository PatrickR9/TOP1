<?php

namespace App\Livewire\DEditor;

use Livewire\Component;
use App\Http\Controllers\Content2MetaFieldsAutosaveController;
use App\Models\Content;

class ContentMaterials extends Component
{
    public $autoSaveTimeStep = 30; # 5 minutes
    public $contentId;    // from Liverwire parameter in resources\views\d_editor\index.blade.php line 21
    public $contentTextLength = 0; 
    public $listeners = 
    [
        'reloadMetaVersion' => 'reloadMetaVersion'
    ];
    public $metaInputFields = [];
    public $metaFields;
    public $step;
    public $updateTimestamp = false;

     public function metaUpdateTimer()
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
        $this->skipRender();
    }
    # end of insert into LiveWire component 

    public function mount()
    {
        $currentContent = Content::find($this->contentId);
        foreach($currentContent->siteblocks as $siteBlock)
        {
            $this->contentTextLength += mb_strlen(trim(strip_tags($siteBlock['content'])));
        }        
        $this->step = 4;
        $this->metaFields = Content2MetaFieldsAutosaveController::getMetaFields($this->step);
        $autoSavedMetaData = Content2MetaFieldsAutosaveController::getAutoSavedMetaValues($this->contentId);
        foreach($this->metaFields as &$metaField)
        {
            $metaField['typeDecoded'] = json_decode($metaField['type'], true);
            unset($metaField['type']);
            $metaField['metaFieldDataSource'] = json_decode($metaField['data_source'], true);
            unset($metaField['data_source']);

            foreach($metaField['typeDecoded'] as $metaCounter => $metaSubFieldType)
            {
                if(isset($autoSavedMetaData[$metaField['id']][$metaCounter]))
                {
                    $this->metaInputFields['mf_'.$metaField['id']][$metaCounter] = $autoSavedMetaData[$metaField['id']][$metaCounter];
                }
                else
                {
                    if($metaSubFieldType === 'enum')
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
    public function reloadMetaVersion($versionVars)
    {
        dump($versionVars);
    }
    public function render()
    {
        return view('livewire.d-editor.content-materials');
    }
}

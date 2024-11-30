<?php

namespace App\Livewire\DEditor;

use App\Http\Controllers\EditorController;
use App\Http\Controllers\UsersiteController;
use App\Models\Siteblock;
use App\Models\SiteblocksAutosave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;


class DEditor extends Component
{
    public $autoSaveStarted = false;
    public $autoSaveTimeStep = 300; # 5 minutes
    public $blockLocked;
    public $checkedValues = ['', 'checked'];
    public $classValues;
    public $contentId; # load from resources\views\d_editor\index.blade.php * for contents only
    public $currentUsersite;
    public $currentUsersiteName;
    public $deMsg = '';
    protected $listeners = 
    [
        'reloadBlockVersion' => 'reloadBlockVersion',
        'saveAndNext' => 'saveAndNext',
        'setContentAttribs' => 'setContentAttribs',
        'setEditorMedium' => 'setEditorMedium'
    ];
    public $lastAutosaveVersion = 0;
    public $maxAutoSave = 20;    # max count of autsaved version of any blocks
    public $preparedBlockId;
    public $siteId; # load from resources\views\d_editor\index.blade.php* for usersites only
    public $siteType; # load from resources\views\d_editor\index.blade.php
    public $updateTimestamp = false;
    public function apply($dEditorBoxes)
    {
    }
    private function applyContent($dEditorBoxes)
    {
        $sortNumber = 0;
        $foreignIdField = 'content_id';
        Siteblock::where('content_id', '=', $this->contentId)->delete();
        foreach($dEditorBoxes as $siteBlockId => $dEditorBox)
        {
            if(isset($this->currentUsersite->siteBlocks[$siteBlockId]))
            {
                $currentDom = new \DOMDocument();
                $currentDom->loadHTML('<?xml encoding="utf-8" ?>'.$dEditorBox);
                $contentBox = $currentDom->getElementById($siteBlockId);
                if($contentBox)
                {
                    $innerHtml = '';
                    foreach($contentBox->childNodes as $childNode)
                    {
                        $innerHtml .= $currentDom->saveHTML($childNode);
                    }
                    $this->currentUsersite->siteBlocks[$siteBlockId]->content = $innerHtml;
                    $siteBlock = Siteblock::withTrashed()->where('content_id', '=', $this->contentId)->where('editor_id', '=', $siteBlockId)->first();
                    if(!isset($siteBlock->content_id))
                    {
                        $siteBlock = new Siteblock();
                        $siteBlock->content_id = $this->contentId;
                        $siteBlock->editor_id = $siteBlockId;
                        $siteBlock->session_id = session()->getId();
                    }
                    else
                    {
                        $siteBlock->restore();
                    }
                    $siteBlock->tag = $this->currentUsersite->siteBlocks[$siteBlockId]->tag;
                    $siteBlock->attribs = json_encode($this->currentUsersite->siteBlocks[$siteBlockId]->attribs, JSON_UNESCAPED_UNICODE);
                    $siteBlock->editor_attribs = json_encode($this->currentUsersite->siteBlocks[$siteBlockId]->editor_attribs, JSON_UNESCAPED_UNICODE);
                    $siteBlock->content = $this->currentUsersite->siteBlocks[$siteBlockId]->content;
                    $siteBlock->sort = $sortNumber;
                    $siteBlock->save();
                    $sortNumber++;
                }
            }
        }
        # remove all autosaved records of current content
        SiteblocksAutosave::where('content_id', '=', $this->contentId)->delete();
    }
    private function applySite()
    {
        # similar to applyContent * user $this->siteId except $this->contentId
        $foreignIdField = 'usersite_id';
        dd('SITE');
        $this->skipRender();
    }
    public function blockDelete($blockId = null, $deleteConfirmed = null)
    {
        if(isset($blockId))
        {
            if(isset($deleteConfirmed) && $blockId = $this->preparedBlockId)
            {
                unset($this->currentUsersite->siteBlocks[str_replace('_block_', '_content_', $blockId)]);
                unset($this->preparedBlockId);
            }
            else
            {
                $this->preparedBlockId = $blockId;
            }
        }
        else
        {
            unset($this->preparedBlockId);
        }
    }
    public function dEditorMediaPool($targetType, $targetId, $acceptedTypes)
    {
        $this->dispatch('openPool', ['dispatch' => 'setEditorMedium', 'source' => 'protected', 'id' => $this->currentUsersite->organisationId, 'type' => $targetType, 'target' => $targetId, 'accepted' => $acceptedTypes]);
        $this->skipRender();
    }
    private function makeAutoCopy()
    {
        $savedSiteBlock = SiteblocksAutosave::where('content_id', '=', $this->contentId)
        ->orderBy('updated_at', 'desc')
        ->get();    # get last auto saved version of block
        if(isset($savedSiteBlock[0]))
        {
            $this->lastAutosaveVersion = ($savedSiteBlock[0]->autosave_version + 1) % $this->maxAutoSave; # next version number
            SiteblocksAutosave::where('content_id', '=', $this->contentId)->where('autosave_version','=', $this->lastAutosaveVersion)->delete();            
        }
        $sortNumber = 0;
        $incrementAutosaveVersion = true;
        foreach($this->currentUsersite->siteBlocks as $siteBlockId => $dEditorBox)
        {
            if(!isset($siteBlock)) # create new record 
            {
                $siteBlock = new SiteblocksAutosave();
                if(isset($savedSiteBlockId))
                {
                    $siteBlock->siteblock_id = $savedSiteBlockId;
                }
                $siteBlock->autosave_version = $this->lastAutosaveVersion;
                $siteBlock->content_id = $this->contentId;
                $siteBlock->editor_id = $siteBlockId;
                $siteBlock->session_id = session()->getId();
                $siteBlock->version_type = 0;
                $siteBlock->version_number = 0;

            }
            $siteBlock->tag = $dEditorBox->tag;
            $siteBlock->attribs = json_encode($dEditorBox->attribs, JSON_UNESCAPED_UNICODE);
            $siteBlock->editor_attribs = json_encode($dEditorBox->editor_attribs, JSON_UNESCAPED_UNICODE);
            $siteBlock->content = $dEditorBox->content;
            $siteBlock->sort = $sortNumber;
            $siteBlock->save();
            unset($siteBlock);
            $sortNumber++;
        }
    }
    public function mount()
    {
        $this->classValues = EditorController::getClassValues();
        switch($this->siteType)
        {
            case 'content':
            {
                $currentUsersite = UsersiteController::getUserContent($this->contentId); # get content siteblocks inclusive
                break;
            }
            case 'page':
            {
                $currentUsersite = UsersiteController::getUserSite($this->siteId); # get user site blocks inclusive
                break;
            }
        }
        $this->currentUsersite = new \stdClass();
        $this->currentUsersite->siteBlocks = [];            # object for output
        if(isset($currentUsersite->organisation_id))
        {
            $this->currentUsersite->organisationId = $currentUsersite->organisation_id;
        }
        $this->blockLocked = count($currentUsersite->siteBlocks) > 0; # if there are not blocks editing is enabled
        foreach($currentUsersite->siteBlocks as $siteBlock)
        {
            $this->blockLocked = UsersiteController::lockSiteBlock($siteBlock->id) && $this->blockLocked;
            $currentSiteBlock = new \stdClass();
            $currentSiteBlock->attribs = [];
            $currentSiteBlock->editor_id = $siteBlock->editor_id;
            $currentSiteBlock->tag = $siteBlock->tag;
            $currentSiteBlock->content = $siteBlock->content;
            $currentSiteBlock->attribs = json_decode($siteBlock->attribs, true);
            if(!isset($currentSiteBlock->attribs['data-class-width']))
            {
                $currentSiteBlock->attribs['data-class-width'] = 'w100';
            }
            $currentSiteBlock->editor_attribs = json_decode($siteBlock->editor_attribs, true);
            if(isset($currentSiteBlock->editor_attribs['class']))
            {
                $currentSiteBlock->editor_attribs['class'] = trim(str_replace(['data-tmc-initialized', 'mce-content-body'], ['', ''], $currentSiteBlock->editor_attribs['class']));
            }
            $this->currentUsersite->siteBlocks[$siteBlock->editor_id] = $currentSiteBlock;
        }
        $lastAutosave = SiteblocksAutosave::select('autosave_version')->where('content_id', '=', $this->contentId)->orderBy('updated_at', 'desc')->first();
        if(isset($lastAutosave))
        {
            $this->lastAutosaveVersion = $lastAutosave->autosave_version;
        }
    }
    public function reloadBlockVersion($versionVars)
    {
        switch($versionVars['versionType'])
        {
            case 'vt2': # auto saved versions
            {
                # content
                if(isset($this->contentId))
                {
                    $reloadedBlocks = SiteblocksAutosave::where('content_id', '=', $this->contentId)
                        ->where('autosave_version', '=', str_replace('vn', '', $versionVars['versionNumber']))
                        ->orderBy('sort', 'asc')->get();
                }
                # site 
                elseif(isset($this->siteId))
                {
                }
                break;
            }
            case 'vt0': # saved edited versions
            {
                # content
                if(isset($this->contentId))
                {
                    $reloadedBlocks = Siteblock::where('content_id', '=', $this->contentId)
                        ->where('version_type', '=', 0)
                        ->orderBy('sort', 'asc')->get();
                }
                # site
                elseif(isset($this->siteId))
                {
                }
                break;
            }
        }
        if(isset($reloadedBlocks))
        {
            $this->currentUsersite->siteBlocks = [];
            foreach($reloadedBlocks as $siteBlock)
            {
                $currentSiteBlock = new \stdClass();
                $currentSiteBlock->attribs = [];
                $currentSiteBlock->editor_id = $siteBlock->editor_id;
                $currentSiteBlock->tag = $siteBlock->tag;
                $currentSiteBlock->content = $siteBlock->content;
                $currentSiteBlock->attribs = json_decode($siteBlock->attribs, true);
                if(!isset($currentSiteBlock->attribs['data-class-width']))
                {
                    $currentSiteBlock->attribs['data-class-width'] = 'w100';
                }
                $currentSiteBlock->editor_attribs = json_decode($siteBlock->editor_attribs, true);
                if(isset($currentSiteBlock->editor_attribs['class']))
                {
                    $currentSiteBlock->editor_attribs['class'] = trim(str_replace(['data-tmc-initialized', 'mce-content-body'], ['', ''], $currentSiteBlock->editor_attribs['class']));
                }
                $this->currentUsersite->siteBlocks[$siteBlock->editor_id] = $currentSiteBlock;
            }
        }
        $this->dispatch('reRender', []);
        $this->dispatch('stopWait', []);
    }
    public function render()
    {
        $viewParams = 
        [
            'blockProperties' => '',
            'step' => 2
        ];
        if(isset($this->contentId))
        {
            $viewParams['editedSource'] = 'content';
        }
        else
        {
            $viewParams['editedSource'] = 'site';
        }
        return view('livewire.d-editor.d-editor', $viewParams);
    }
    public function setContentAttribs($blockId, $attribType, $attribValue) # from Livewire Properties
    {
        if(isset($this->currentUsersite->siteBlocks[$blockId]))
        {
            if(is_array($attribType))
            {
                foreach($attribType as $attribTypeIndex => $attribTypeName)
                {
                    $this->currentUsersite->siteBlocks[$blockId]->attribs[$attribTypeName] = $attribValue[$attribTypeIndex];    
                }
            }
            else
            {
                $this->currentUsersite->siteBlocks[$blockId]->attribs[$attribType] = $attribValue;
            }
        }
    }
    public function setContentEditorAttribs($blockId, $attribType, $attribValue)
    {
        if(isset($this->currentUsersite->siteBlocks[$blockId]))
        {
            if(is_array($attribType))
            {
                foreach($attribType as $attribTypeIndex => $attribTypeName)
                {
                    if($attribValue[$attribTypeIndex] === true)
                    {
                        $this->currentUsersite->siteBlocks[$blockId]->editor_attribs[$attribTypeName] = 'checked';
                    }
                    elseif($attribValue[$attribTypeIndex] === false)
                    {
                        $this->currentUsersite->siteBlocks[$blockId]->editor_attribs[$attribTypeName] = '';
                    }
                    else
                    {
                        $this->currentUsersite->siteBlocks[$blockId]->editor_attribs[$attribTypeName] = $attribValue[$attribTypeIndex];
                    }
                }
            }
            else
            {
                if($attribValue === true)
                {
                    $this->currentUsersite->siteBlocks[$blockId]->editor_attribs[$attribTypeName] = 'checked';
                }
                elseif($attribValue === false)
                {
                    $this->currentUsersite->siteBlocks[$blockId]->editor_attribs[$attribTypeName] = '';
                }
                else
                {
                    $this->currentUsersite->siteBlocks[$blockId]->editor_attribs[$attribTypeName] = $attribValue;
                }
            }
            foreach($this->classValues as $property => $propertyValues)
            {
                if(count($propertyValues['options']) > 0)
                {
                    if(!isset($this->currentUsersite->siteBlocks[$blockId]->attribs['data-class-'.$property]))
                    {
                        $propertyIndexes = array_keys($propertyValues['options']);
                        $this->currentUsersite->siteBlocks[$blockId]->attribs['data-class-'.$property] = $propertyIndexes[0];
                    }
                }
            }
            switch($this->currentUsersite->siteBlocks[$blockId]->editor_attribs['data-content-type'])
            {
                case 'figure':
                {
                    $this->currentUsersite->siteBlocks[$blockId]->content = EditorController::drawFigure(array_merge($this->currentUsersite->siteBlocks[$blockId]->editor_attribs, ['editor_content_id' => $blockId]), $this->currentUsersite->siteBlocks[$blockId]->content)->content;
                    break;
                }
                case 'table':
                {
                    $this->currentUsersite->siteBlocks[$blockId]->content = EditorController::drawTable(array_merge($this->currentUsersite->siteBlocks[$blockId]->editor_attribs, ['editor_content_id' => $blockId]), $this->currentUsersite->siteBlocks[$blockId]->content)->content;
                    break;
                }
            }
        }
    }
    public function setEditorMedium($poolData)
    {
        $figureImageId = $poolData['targetId'];
        $editorId = str_replace('_figure_image_', '_content_', $figureImageId);
        $currentDom = new \DOMDocument();
        $currentDom->loadHTML('<?xml encoding="utf-8" ?>'.$this->currentUsersite->siteBlocks[$editorId]->content);
        $figureBlock = $currentDom->getElementById($figureImageId);
        if(isset($figureBlock))
        {
            $figureBlock->setAttribute('src', '/image/'.$poolData['mediumId']);
            if(isset($poolData['mediumData']['label']))
            {
                $figureBlock->setAttribute('alt', $poolData['mediumData']['label']);
            }
            else
            {
                $figureBlock->setAttribute('alt', '/image/'.$poolData['mediumId']);
            }
            $this->currentUsersite->siteBlocks[$editorId]->content = $currentDom->saveHTML($figureBlock);
        }
        $figureCaptionId = str_replace('_figure_image_', '_figure_image_caption_', $figureImageId);
        $figureCaptionBlock = $currentDom->getElementById($figureCaptionId);
        if(isset($figureCaptionBlock))
        {
            $this->currentUsersite->siteBlocks[$editorId]->content = $currentDom->saveHTML($figureBlock).$currentDom->saveHTML($figureCaptionBlock);
        }

    }
    public function saveAndNext($dEditorBoxes, $toNext)
    {
        if($this->siteType === 'content')
        {
            $this->applyContent($dEditorBoxes);
        }
        else
        {
            $this->applySite($dEditorBoxes);
        }
        if($toNext)
        {
            return redirect()->route('content.materials', ['id' => $this->contentId]);
        }
        else
        {
//            $this->skipRender();
        }
    }
    public function updateSessionSiteBlock($siteBlockId, $siteBlockContent, $siteBlockIds)
    {
        # set sort order
        $siteBlockIds = json_decode($siteBlockIds, true);
        $tempSiteBlocks = $this->currentUsersite->siteBlocks;
        $this->currentUsersite->siteBlocks = [];
        foreach($siteBlockIds as $blockId)
        {
            $editorId = str_replace('_block_', '_content_', $blockId); 
            if(isset($tempSiteBlocks[$editorId]))
            {
                $this->currentUsersite->siteBlocks[$editorId] = $tempSiteBlocks[$editorId];
            }
            else
            {
                $this->currentUsersite->siteBlocks[$editorId] = new \stdClass();
            }
        }
        # set content 
        $editorId = str_replace('_block_', '_content_', $siteBlockId);
        $currentDom = new \DOMDocument();
        $currentDom->loadHTML('<?xml encoding="utf-8" ?>'.$siteBlockContent);
        $contentBox = $currentDom->getElementById($editorId);
        if($contentBox)
        {
            $innerHtml = '';
            foreach($contentBox->childNodes as $childNode)
            {
                $innerHtml .= $currentDom->saveHTML($childNode);
            }
            $this->currentUsersite->siteBlocks[$editorId]->content = $innerHtml;
            if(!isset($this->currentUsersite->siteBlocks[$editorId]->editor_id))
            {
                $siteBlockAttribs = [];
                $siteBlockEditorAttribs = [];
                foreach($contentBox->attributes as $attribute)
                {
                    if($attribute->nodeName === 'class')
                    {
                        $attribute->nodeValue = trim(str_replace('mce-edit-focus', '', $attribute->nodeValue));
                    }
                    if(strpos($attribute->nodeName, 'data-frontend-') === 0)
                    {
                        $siteBlockAttribs[str_replace('data-frontend-', '', $attribute->nodeName)] = $attribute->nodeValue;
                    }
                    elseif(strpos($attribute->nodeName, 'data-class') === 0)
                    {
                        $siteBlockAttribs[$attribute->nodeName] = $attribute->nodeValue;
                    }
                    elseif($attribute->nodeName !== 'id')
                    {
                        $siteBlockEditorAttribs[$attribute->nodeName] = $attribute->nodeValue;
                    }
                }
                $siteBlockEditorAttribs['data-tmce-reset'] = "true";
                $this->currentUsersite->siteBlocks[$editorId]->editor_id = $editorId;
                $this->currentUsersite->siteBlocks[$editorId]->editor_attribs = $siteBlockEditorAttribs;
                $this->currentUsersite->siteBlocks[$editorId]->attribs = $siteBlockAttribs;
                $this->currentUsersite->siteBlocks[$editorId]->tag = $contentBox->nodeName;
            }
        }
        date_default_timezone_set('Europe/Berlin');
        $currentTime = time();     
        if($this->updateTimestamp === false)
        {
            $this->makeAutoCopy();
            $this->updateTimestamp = $currentTime + $this->autoSaveTimeStep;
        }
        else
        {
            if($this->updateTimestamp <= $currentTime)
            {
                $this->makeAutoCopy();
                $this->updateTimestamp = $currentTime + $this->autoSaveTimeStep;
            }
        }
        $this->dispatch('reRender', []);
        $this->skipRender();
    }
}

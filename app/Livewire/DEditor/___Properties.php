<?php

namespace App\Livewire\DEditor;

use App\Http\Controllers\UsersiteController;
use App\Models\Siteblock;
use Illuminate\Http\Request;
use Livewire\Component;

class Properties extends Component
{
    private $blockPropertyBoxClass = 'accordion_block_inner';
    # add new blocks on css base to have property select field
    private $definedAttribs = 
    [
        'class' => 
        [
            'width' =>
            [
                'w100' => 'voll',
                'w2_3' => '2/3',
                'w50' => '1/2',
                'w1_3' => '1/3',
            ],
/*            'background' => 
            [
                'none' => 'transparent',
                'bg-white' => 'HG weiß',
                'bg-light-gray' => 'HG hellgrau',
                'bg-medium-gray' => 'HG grau',
                'bg-dark-gray' => 'HG dunkelgrau'
            ],
            'border' => 
            [
                'none' => 'keine Rahmen',
                'bordered' => 'Rahmen',
                'v-borders' => 'vertikale Rahmen',
                'h-borders' => 'horizontale Rahmen'
            ]*/
        ]
    ];
    private $msg = '';
    private $reloadEnabled;

    protected $popupParams;

    public $blockId;
    public $classOptions;
    public $contentId;
    public $leavePrepared = false;
    public $resolution = 'desktop';
    public $siteBlocks;
    public $siteId;
    public $userSiteBlockAttribs = [];

    private function getDefinedAttrib($attribName, $subCategory)
    {
        $returnAttrib = null;
        if(isset($this->definedAttribs[$attribName][$subCategory]))
        {
            $returnAttrib = $this->definedAttribs[$attribName][$subCategory];
        }
        return $returnAttrib;
    }
    public function leaveEditor($leaveStatus)
    {
        if(intval($leaveStatus) === 1)
        {
            $this->leavePrepared = true;
            $this->popupParams = 
            [
                'close_button' => 'none',
                'content' => '
                <form onsubmit = "return false;">
                    '.csrf_field().'
                    <input type = "hidden" name = "id" value = "'.$this->siteId.'">
                    <p class = "d_editor_info">Der Inhalt der Website hat sich geändert. Möchten Sie die Änderungen speichern oder die Bearbeitung fortsetzen?</p>
                    <div class = "d_editor_popup_buttons right">
                        <button class = "button" type = "button" wire:click = "leaveEditor(0)">weiter bearbeiten</button>
                        <button class = "button" type = "button" onclick = "siteSave(this.form);dEditorPopupClose();">speichern</button>
                    </div>
                </form>'
            ];
        }
        else
        {
            $this->leavePrepared = false;
        }
    }
    public function loadBlockProperties($blockId)
    {
        if($this->blockId === $blockId)
        {
            $this->reloadEnabled = false;
        }
        else
        {
            $this->blockId = $blockId;
            $this->contentId = str_replace('_block_', '_content_', $blockId);
            if(isset($this->siteBlocks[$this->contentId]))
            {
                $this->userSiteBlockAttribs = $this->siteBlocks[$this->contentId];
            }
            else
            {
                $userSiteBlock = Siteblock::where('editor_id', $this->contentId)->first();
                if(isset($userSiteBlock))
                {
                    $this->siteId = $userSiteBlock->usersite_id;
                    if(isset($userSiteBlock))
                    {
                        $decodedAttribs = json_decode($userSiteBlock->attribs, true);
                        foreach($decodedAttribs as $attribName => $attribValues)
                        {
                            $subCategories = array_keys($this->definedAttribs[$attribName]);
                            $attribValues = explode(" ", $attribValues);
                            foreach($attribValues as $index => $attribValue)
                            {
                                $this->userSiteBlockAttribs[$attribName][$subCategories[$index]] = $attribValue;
                                $index++;
                            } /** */
                        } 
                    }
                    else
                    {
                        $this->userSiteBlockAttribs = [];
                    }
                }
                else
                {
                    $this->userSiteBlockAttribs = [];
                }
            }
            if(!isset($this->userSiteBlockAttribs['class']))
            {
                $this->userSiteBlockAttribs['class'] = ['width' => 'w100'];
            }
            foreach($this->classOptions as $attribName => $none)
            {
                if(!isset($this->userSiteBlockAttribs['class'][$attribName]))
                {
                    $this->userSiteBlockAttribs['class'][$attribName] = array_keys($this->definedAttribs['class'][$attribName])[0];
                }
            }
        }
        $this->msg = count($this->userSiteBlockAttribs);
    }
    public function mount()
    {
/*        if(session()->has('siteBlocks'))
        {
            $this->siteBlocks = session()->get('siteBlocks');
        }
        else*/
        {
            $this->siteBlocks = [];
        }
        foreach($this->definedAttribs['class'] as $subCategory => $classOptions)
        {
            $this->classOptions[$subCategory] = '';
            foreach($classOptions as $value => $label)
            {
                $this->classOptions[$subCategory] .= '
                <option value = "'.$value.'">'.$label.'</option>';
            }
        }
    }
/*    public function newPropertyInputRow($attribName)
    {
        if(!isset($this->userSiteBlockAttribs[$attribName]))
        {
            $this->userSiteBlockAttribs[$attribName] = [];
        }
        $this->userSiteBlockAttribs[$attribName][] = ''; 
        $this->reloadEnabled = false;
    }
    public function removePropertyInputRow($attribName, $attribIndex)
    {
        unset($this->userSiteBlockAttribs[$attribName][intval($attribIndex)]);
        $this->reloadEnabled = false;
    } */
    public function render()
    {
        $this->msg = ' Count formatter blocks: '.count($this->siteBlocks);
        $viewParams = 
        [
            'blockPropertyBoxClass' => $this->blockPropertyBoxClass,
            'msg' => $this->msg,
            'popupParams' => $this->popupParams
        ];
        return view('livewire.d-editor.properties', $viewParams);
    }
    public function setBlockAttributes($attribCategoryName)
    {
        $this->reloadEnabled = false;
        $attribValue = '';
        $divider = '';
        foreach($this->userSiteBlockAttribs[$attribCategoryName] as $attribCategoryValue)
        {
            if($attribCategoryValue != '')
            {
                $attribValue .= $divider.$attribCategoryValue;
                $divider = ' ';
            }
        }
        $this->msg = 'contentID: '.$this->contentId.' ; userSiteBlockAttribs: '.count($this->userSiteBlockAttribs);

        $this->siteBlocks[$this->contentId] = $this->userSiteBlockAttribs;
//        session(['siteBlocks' => $this->siteBlocks]);
        $this->dispatch('setContentAttribs', ['contentId' => $this->contentId, 'attribName' => $attribCategoryName, 'attribValue' => implode(' ', $this->userSiteBlockAttribs[$attribCategoryName])]);
        $this->userSiteBlockAttribs = [];
//        $this->skipRender();
    }
    public function setLastActivity()
    {
        if(isset($this->siteId))
        {
/*            dump($this->siteId);
/*            $currentUsersite = UsersiteController::getUserSite($this->siteId);
            foreach($currentUsersite->siteBlocks as $siteBlock)
            {
                UsersiteController::lockSiteBlock($siteBlock->id);
            }*/
        }
        $this->skipRender();
    }
}

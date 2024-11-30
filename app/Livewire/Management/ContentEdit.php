<?php

namespace App\Livewire\Management;

use App\Http\Classes\Crm;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\UsersiteController;
use App\Models\Content;
use App\Models\Editorial;
use App\Models\Organisation;
use App\Models\ContentMetaField;
use App\Models\Content2MetaField;
use Illuminate\Http\Request;
use Livewire\Component;



class ContentEdit extends Component
{
    public $author_id;
    private $content;
    public $editFields = 
    [
        'organisation_id' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Verband',
            'list' => false,
            'hidden' => true
        ],
        'editorial_id' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Redaktion',
            'list' => false,
            'hidden' => true
        ],
        'author_id' =>
        [
            'tag' => 'input',
            'attribs' => '',
            'label' => '',
            'hidden' => true
        ],
    ];
    public $editorial_id;
    public $id = 'new';
    public $listeners = 
    [
        'applyStep1' => 'apply'
    ];
    public $organisation_id;
    public $selectedFunction = '';
    public $title = '';
    public $titleFieldId;
    public $type = 'einheit';

    public function apply()
    {
        $validated = $this->validate([
            'title' => 'required|max:255',
            'organisation_id' => 'required|integer',
            'editorial_id' => 'required|integer'
        ]);
        # if validated
        $content = $this->getContent($this->id);
        $content->type = $this->type;
        $content->organisation_id = $this->organisation_id;
        $content->editorial_id = $this->editorial_id;
        $content->author_id = $this->author_id;
        $content->save();
        if($this->id === 'new')
        {
            $this->id = $content->id;
        }
        # get meta data of edited version
        $metaData = Content2MetaField::where('content_id', '=', $this->id)->where('content_meta_field_id', '=', $this->titleFieldId)->where('version_type', '=', 0)->first();
        if(!isset($metaData))
        {
            $metaField = ContentMetaField::find($this->titleFieldId); # get properties of Title
            $metaData = new Content2MetaField;
            $metaData->content_id = $this->id;
            $metaData->content_meta_field_id = $this->titleFieldId;
            $metaData->sort = $metaField->sort;
        }
        $metaData->value = $this->title;
        $metaData->save();
    }
    private function getContent($contentId)
    {
        if(intval($contentId) !== 0)
        {
            $this->id = $contentId;
            $content = Content::find($this->id);
        }
        if(!isset($content))
        {
            $content = new Content();
        }
        return $content;
    }
    public function mount($contentId)
    {
        $content = $this->getContent($contentId);
        $this->titleFieldId = UsersiteController::getMetaTitleFieldId();
        $metaData = UsersiteController::getUserContentMetaArray($contentId, [$this->titleFieldId], 0); # get meta: title of edited version
        if(isset($metaData[0]) && isset($metaData[0]['value']))
        {
            $this->title = $metaData[0]['value'];
        }
        else
        {
            $this->title = '';
        }
        $this->type = $content->type;
        $this->organisation_id = $content->organisation_id;
        $this->editorial_id = $content->editorial_id;
        $this->author_id = $content->author_id;
        $currentTeamRole = ManagementController::userTeam();
        $this->author_id = $currentTeamRole->user_id;
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $this->editFields['organisation_id']['options'] = Crm::createSelectOptions(Organisation::select('id', 'title')->orderBy('title')->get()->toArray(), $this->organisation_id);
                $this->editFields['editorial_id']['options'] = Crm::createSelectOptions(Editorial::select('id', 'title')->orderBy('title')->get()->toArray(), $this->editorial_id);
                break;
            }
            default:
            {
                # where editorial_members.user_id=users.id
/*                $this->editFields['organisation_id']['options'] = Crm::createSelectOptions(Organisation::select('id', 'title')->orderBy('title')->get()->toArray(), $this->organisation_id);
                $this->editFields['editorial_id']['options'] = Crm::createSelectOptions(Editorial::select('id', 'title')->orderBy('title')->get()->toArray(), $this->editorial_id);*/
                break;
            }
        }
    }
    public function render()
    {
        $viewParams = 
        [
            'step' => 1,
            'currentSiteName' => $this->title,
            'formId' => 'content_form_'.date('U')
        ];
        return view('livewire.management.content-edit', $viewParams);
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
        return redirect()->route('content.content', ['id' => $this->id]);
    }
    public function toEdit()
    {
        $this->selectedFunction = '';
    }
    public function toListPrepare()
    {
        $this->selectedFunction = 'toListPrepare';
    }
    public function toList()
    {
        return redirect()->to('/contents');
    }
}

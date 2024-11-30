<?php

namespace App\Livewire\DEditor;

use Livewire\Component;
use App\Http\Classes\Crm;
use App\Models\Content as contentModel;

class ContentProperties1 extends Component
{
    public $id;
    public $title;

    # input fields of the table
    public $type;
    public $text;
    public $short_text;
    public $mediapool_id;
    public $exzerpt;
    public $preparation_time_from;
    public $preparation_time_until;
    public $duration_time_from;
    public $duration_time_until;
    public $bible_passage;
    public $additional_bible_passages;
    public $attachments;
    public $alternative_authors;
    public $external_rights;
    public $visibility;
    public $visibility_date;
    public $status;

    # attribs
    public $editFields =
    [
        'mediapool_id' =>
        [
            'tag' => 'media',
            'attribs' => 'type = "hidden" accept="image/png, image/jpeg, image/svg+xml"',
            'label' => 'Bild',
            'list' => false
        ],
        'type' =>
        [
            'tag' => 'select',
            'attribs' => 'type = "text"',
            'label' => 'Typ',
            'list' => true,
        ],
        'text' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text"',
            'label' => 'Text',
            'list' => false,
        ],
        'short_text' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Kurztext',
            'list' => false,
        ],
        'exzerpt' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'exzerpt',
            'list' => false,
        ],
        'preparation_time_from' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "number" min = "0"',
            'label' => 'preparation_time_from',
            'list' => false,
        ],
        'preparation_time_until' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "number" min = "0"',
            'label' => 'preparation_time_until',
            'list' => false,
        ],
        'duration_time_from' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "number" min = "0"',
            'label' => 'duration_time_from',
            'list' => true,
        ],
        'bible_passage' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "api_search" data-source = "bible_api"',
            'label' => 'bible_passage',
            'list' => false,
        ],
        'additional_bible_passages' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "api_search" data-source = "bible_api"',
            'label' => 'additional_bible_passages',
            'list' => false,
        ],
        'attachments' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text"',
            'label' => 'Anhänge',
            'list' => false,
        ],
        'alternative_authors' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "email" class = "input_long"',
            'label' => 'alternative Authoren',
            'list' => false,
        ],
        'external_rights' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'external_rights',
            'list' => false,
        ],
        'visibility' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'visibility',
            'list' => true
        ],
        'visibility_date' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "datetime-local"',
            'label' => 'visibility_date',
            'list' => false
        ],
        'status' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Status',
            'list' => true
        ]
    ];

    public $selectedFunction = '';

    public function apply()
    {
        $validated = $this->validate([
            'type' => 'required',
            'text' => 'required'
        ]);
        # if validated
        $content = $this->getContent($this->id);
        $content->type = $this->type;
        $content->text = $this->text;
        $content->short_text = $this->short_text;
        $content->mediapool_id = $this->mediapool_id;
        $content->exzerpt = $this->exzerpt;
        $content->preparation_time_from = $this->preparation_time_from;
        $content->preparation_time_until = $this->preparation_time_until;
        $content->duration_time_from = $this->duration_time_from;
        $content->duration_time_until = $this->duration_time_until;
        $content->bible_passage = $this->bible_passage;
        $content->additional_bible_passages = $this->additional_bible_passages;
        $content->attachments = $this->attachments;
        $content->alternative_authors = $this->alternative_authors;
        $content->external_rights = $this->external_rights;
        $content->visibility = $this->visibility;
        $content->visibility_date = $this->visibility_date;
        $content->status = $this->status;
        $content->save();
    }

    private function getContent($contentId)
    {
        if(intval($contentId) !== 0)
        {
            $this->id = $contentId;
            $content = ContentModel::find($this->id);
        }

        return $content;
    }

    public function mount($contentId)
    {
        $content = $this->getContent($contentId);
        $this->title = $content->title;
        $this->type = $content->type;
        $this->text = $content->text;
        $this->short_text = $content->short_text;
        $this->mediapool_id = $content->mediapool_id;
        $this->exzerpt = $content->exzerpt;
        $this->preparation_time_from = $content->preparation_time_from;
        $this->preparation_time_until = $content->preparation_time_until;
        $this->duration_time_from = $content->duration_time_from;
        $this->duration_time_until = $content->duration_time_until;
        $this->bible_passage = $content->bible_passage;
        $this->additional_bible_passages = $content->additional_bible_passages;
        $this->attachments = $content->attachments;
        $this->alternative_authors = $content->alternative_authors;
        $this->external_rights = $content->external_rights;
        $this->visibility = $content->visibility;
        $this->visibility_date = $content->visibility_date;
        $this->status = $content->status;

        $enumFields = Crm::getEnumFields('contents');
        foreach ($enumFields as $enumField => $enumValues) {

            $this->editFields[$enumField]['options'] = Crm::createSelectOptions($enumValues, $this->$enumField);
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
        return redirect()->route('content.check', ['id' => $this->id]);
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

    public function render()
    {
        $viewParams = 
        [
            'step' => 3,
            'currentSiteName' => $this->title,
            'formId' => 'content_form_'.date('U')
        ];
        return view('livewire.d-editor.content-properties1', $viewParams);
    }
}

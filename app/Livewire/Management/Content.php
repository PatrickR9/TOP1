<?php

namespace App\Livewire\Management;

use App\Models\Content as contentModel;
use App\Http\Classes\Crm;
use App\Http\Controllers\ManagementController;
use App\Models\Editorial;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Schema;

class Content extends Component
{
    # input fields of the table
    public $id;
    public $title;
    public $organisation_id;
    public $editorial_id;
    public $author_id;

    # id fields
    public $idDelete;
    public $idEdit;
    public $idInsert;

    # input fields of the table to edit
    public $titleEdit;
    public $organisation_idEdit;
    public $editorial_idEdit;
    public $author_idEdit;
    
    # input fields to filter
    public $editorials = [];
    public $editorialFilteredIds = [];
    public $editorial_titleFilter = '';
    public $organisations = [];
    public $organisationFilteredIds = [];
    public $organisation_titleFilter = '';
    //public $fieldsToFilter = ['organisation_titleFilter', 'editorial_titleFilter', 'titleFilter'];
    public $titleFilter = '';

    # sorting fields
    public $orderBy;

    # attribs
    private $currentUserRole;
    public $currentPage = 1;
    private $modelFields = 
    [
        'id' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "shidden"',
            'label' => 'ID',
            'list' => false,
        ],
        'organisation_id' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Verband',
            'list' => false,
        ],
        'editorial_id' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Redaktion',
            'list' => false,
        ],
        'author_id' =>
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Author',
            'list' => false,
        ],
        'title' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Titel',
            'list' => true,
            'sourceTable' => 'content2_meta_fields',
            'sourceField' => 'value'
        ]
    ];
    public $rowPerPage = 5;
    public $showRecords = 'notDeletedRecords';
    public function cancel()
    {
        unset($this->idDelete);
        unset($this->idInsert);
        unset($this->idEdit);
    }
    public function clearRecordFilter($filterField)
    {
        $this->$filterField = '';
    }
    public function delete($id)
    {
        $this->cancel();
        $this->idDelete = $id;
    }
    public function edit($id = 'new')
    {
        $this->cancel();
        if($id === 'new')
        {
            $this->idInsert = true;
            $selectPostFix = '';
        }
        else
        {
            $editedRecord = contentModel::withTrashed()->find($id)->toArray();
            foreach($editedRecord as $fieldName => $value)
            {
                if(!in_array($fieldName, $this->editDisabled) && isset($this->modelFields[$fieldName]))
                {
                    $editFieldName = $fieldName.'Edit';
                    $this->$editFieldName = $value;
                }
            }
            $selectPostFix = 'Edit';
        }
        $currentEditField = 'organisation_id'.$selectPostFix;
        $this->modelFields['organisation_id']['options'] = Crm::createSelectOptions(Organisation::select('id', 'title')->orderBy('title')->get()->toArray(), $this->$currentEditField);
        $currentEditField = 'editorial_id'.$selectPostFix;
        $this->modelFields['editorial_id']['options'] = Crm::createSelectOptions(Editorial::select('id', 'title')->orderBy('title')->get()->toArray(), $this->$currentEditField);
        $currentEditField = 'author_id'.$selectPostFix;
        $this->modelFields['author_id']['options'] = Crm::createSelectOptions(DB::table('users')->select('id', 'name')->orderBy('name')->get()->toArray(), $this->$currentEditField);
    }
    public function insert()
    {
        $dataArray = [];
        foreach($this->modelFields as $field => $none)
        {
            switch($field)
            {
                case 'id':
                {
                    break;
                }
                default:
                {
                    if(isset($this->$field))
                    {
                        $dataArray[$field] = $this->$field;
                    }
                }
            }
        }
        $contentModel = contentModel::create($dataArray);
        unset($this->idInsert);
    }   # end of insert
    private function list($req)
    {
        $tableName = 'contents';
        $tableFields = Schema::getColumnListing('contents');
        $tableFields[] = 'title';
        $editFields = [];
        $listFields = [];
        switch($this->showRecords)
        {
            case 'deletedRecords':
            {
                $contents = DB::table($tableName)->whereNotNull($tableName.'.deleted_at');
                break;
            }
            case 'all':
            {
                $contents = DB::table($tableName);
                break;
            }
            default:
            {
                $contents = DB::table($tableName)->whereNull($tableName.'.deleted_at');
                break;
            }
        }
        $this->currentUserRole = ManagementController::userTeam();
        switch($this->currentUserRole->role)
        {
            case 'sysadmin':
            case 'groupadmin':
            {
                $contents->select($tableName.'.*', 'content2_meta_fields.value as title', 'organisations.title as organisation_title', 'editorials.title as editorial_title', DB::raw('concat(uservalues.lastname, ", ", uservalues.firstname) as author_fullname'))
                    ->join('organisations', 'organisation_id', '=', 'organisations.id')
                    ->join('editorials', 'editorial_id', '=', 'editorials.id')
                    ->leftJoin('uservalues', 'author_id', '=', 'uservalues.user_id')
                    ->leftJoin('content2_meta_fields', 'contents.id', '=', 'content_id')
                    ->leftJoin('content_meta_fields', function (JoinClause $join) {
                        $join->on('content_meta_fields.id', '=', 'content_meta_field_id')
                             ->where('content_meta_fields.title_field', '=', 1);
                    });
                break;
            }
        }
        foreach($this->modelFields as $field => $modelField)
        {
            if(in_array($field, $tableFields))
            {
                if($modelField['list'] === true)
                {
                    $listFields[$field] = $modelField['label'];
                }
                switch($field)
                {
                    case 'organisation_id':
                    {
                        $listFields['organisation_title'] = $modelField['label'];
                        break;
                    }
                    case 'editorial_id':
                    {
                        $listFields['editorial_title'] = $modelField['label'];
                        break;
                    }
                    case 'author_id':
                    {
                        $listFields['author_fullname'] = $modelField['label'];
                        break;
                    }
                    default:
                    {
                        break;
                    }
                }
                $editFields[$field] = $modelField;
                $filterField = $field.'Filter';
                switch($field)
                {
                    case 'editorial_id':
                    {
                        if(count($this->editorialFilteredIds) > 0)
                        {
                            $contents->whereRaw($field.' in ('.implode(',', $this->editorialFilteredIds).')');
                        }
                        break;
                    }
                    case 'organisation_id':
                    {
                        if(count($this->organisationFilteredIds) > 0)
                        {
                            $contents->whereRaw($field.' in ('.implode(',', $this->organisationFilteredIds).')');
                        }
                        break;
                    }
                    default:
                    {
                        if(isset($this->$filterField) && ($this->$filterField !== ''))
                        {
                            if(isset($modelField['sourceTable']))
                            {
                                $filterTableField = $modelField['sourceTable'].'.'.$modelField['sourceField'];
                            }
                            else
                            {
                                $filterTableField = $tableName.'.'.$field;
                            }
                            $contents->where($filterTableField, 'like', '%'.$this->$filterField.'%');
                        }
                        break;
                    }
                }   # end of switch field
            }
        }
        if(isset($this->orderBy))
        {
            $contents->orderBy($this->orderBy['field'],  $this->orderBy['sort']);
        }
        $viewData = 
        [
            'countOfRecords' => $contents->count(),
            'editFields' => $editFields,
            'listFields' => $listFields
        ];
        $viewData['countOfSites'] = intval(ceil($viewData['countOfRecords'] / $this->rowPerPage));
        if($viewData['countOfSites'] < $this->currentPage)
        {
            $this->currentPage = $viewData['countOfSites'];
        }
        if($this->currentPage > 0)
        {
            $rowOffset = ($this->currentPage - 1) * $this->rowPerPage;
        }
        else
        {
            $rowOffset = 0;
        }
        $viewData[$tableName] = $contents->offset($rowOffset)->limit($this->rowPerPage)->get()->toArray();
        if($viewData['countOfRecords'] === 0)
        {
            $viewData['firstRecord'] = 0;
            $viewData['lastRecord'] = 0;
        }
        else
        {
            $viewData['firstRecord'] = $rowOffset + 1;
            $viewData['lastRecord'] = $this->currentPage * $this->rowPerPage;
            if($viewData['countOfRecords'] < $viewData['lastRecord'])
            {
                $viewData['lastRecord'] = $viewData['countOfRecords'];
            }
        }
        return $viewData;
    }
    public function mount()
    {
        $this->editorials = Crm::createSelectOptions(Editorial::select('id', 'title')->orderBy('title')->get()->toArray());
        $this->organisations = Crm::createSelectOptions(Organisation::select('id', 'title')->orderBy('title')->get()->toArray());
    }
    public function render(Request $req)
    {
        $viewData = $this->list($req);
        return view('livewire.management.content', $viewData);
    }
    public function sort($field)
    {
        if(!isset($this->orderBy['field']) || ($this->orderBy['field'] !== $field))
        {
            $this->orderBy['field'] = $field;
            $this->orderBy['sort'] = 'asc';
        }
        else
        {
            if($this->orderBy['sort'] === 'asc')
            {
                $this->orderBy['sort'] = 'desc';
            }
            else
            {
                $this->orderBy['sort'] = 'asc';
            }
        }
    }
    public function setPagination()
    {
    }
    public function setRecordFilter()
    {
    }
    public function setRowPerPage()
    {
    }
}

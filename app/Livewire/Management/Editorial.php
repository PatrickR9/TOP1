<?php

namespace App\Livewire\Management;

use App\Models\Editorial as editorialModel;
use App\Models\Organisation;
use App\Http\Classes\Crm;
use App\Http\Controllers\ManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Schema;

class Editorial extends Component
{
    use WithFileUploads;

    # input fields of the table
    public $id;
    public $organisation_id;
    public $title;
    public $description;
    public $short_description;
    public $logo;
    public $logo_for_light_bg;
    public $logo_for_dark_bg;
    public $cd_colors;
    
    # id fields
    public $idDelete;
    public $idEdit;
    public $idInsert;

    # input fields of the table to edit
    public $organisation_idEdit;
    public $titleEdit;
    public $descriptionEdit;
    public $short_descriptionEdit;
    public $logoEdit;
    public $logo_for_light_bgEdit;
    public $logo_for_dark_bgEdit;
    public $cd_colorsEdit;
    
    # sorting fields
    private $orderBy;

    # attribs
    private $currentUserRole;
    public $currentPage = 1;
    public $rowPerPage = 5;
    public $showRecords = 'notDeletedRecords';

    private $editDisabled = [];
    private $modelFields = 
    [
        'id' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "hidden"',
            'label' => 'ID',
            'list' => false
        ],
        'organisation_id' => 
        [
            'tag' => 'select',
            'attribs' => '',
            'label' => 'Organisation',
            'list' => false
        ],
        'title' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Titel',
            'list' => true
        ],
        'description' => 
        [
            'tag' => 'textarea',
            'attribs' => 'class = "input_long"',
            'label' => 'Beschreibung',
            'list' => false
        ],
       'short_description' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Kurzbeschreibung',
            'list' => false
        ],
        'logo' =>  
        [
            'tag' => 'media',
            'attribs' => 'type = "hidden" accept="image/png, image/jpeg, image/svg+xml"',
            'label' => 'Logo',
            'list' => false
        ],
        'logo_for_light_bg' =>  
        [
            'tag' => 'media',
            'attribs' => 'type = "hidden" accept="image/png, image/jpeg, image/svg+xml"',
            'label' => 'Logo auf hellen Hintergrund',
            'list' => false
        ],
        'logo_for_dark_bg' =>  
        [
            'tag' => 'media',
            'attribs' => 'type = "hidden" accept="image/png, image/jpeg, image/svg+xml"',
            'label' => 'Logo auf dunklen Hintergrund',
            'list' => false
        ],
        'cd_colors' =>  
        [
            'tag' => 'input',
            'attribs' => 'type = "text"',
            'label' => 'CD-Farbe ????',
            'list' => false
        ],
    ];
    public function cancel()
    {
        unset($this->idDelete);
        unset($this->idInsert);
        unset($this->idEdit);
    }
    public function delete($id)
    {
        $this->cancel();
        $this->idDelete = $id;
    }
    public function deleteConfirmed()
    {
        if(isset($this->idDelete))
        {
            $currentEditorial = editorialModel::find($this->idDelete);
            if(isset($currentEditorial))
            {
                $currentEditorial->delete();
            }
            unset($this->idDelete);
        }
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
            $editedRecord = editorialModel::withTrashed()->find($id)->toArray();
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
        $editorialModel = editorialModel::create($dataArray);
        unset($this->idInsert);
    }   # end of insert
    private function list($req)
    {
        $tableFields = Schema::getColumnListing('editorials');
        $editFields = [];
        $listFields = 
        [
        ];
        foreach($tableFields as $field)
        {
            if(isset($this->modelFields[$field]))
            {
                if($this->modelFields[$field]['list'] === true)
                {
                    $listFields[$field] = $this->modelFields[$field]['label'];
                }
                switch($field)
                {
                    case 'organisation_id':
                    {
                        $listFields['organisation_title'] = $this->modelFields[$field]['label'];
                        break;
                    }
                    default:
                    {
                        break;
                    }
                }
                $editFields[$field] = $this->modelFields[$field];
            }
        }
        switch($this->showRecords)
        {
            case 'deletedRecords':
            {
                $editorials = DB::table('editorials')->whereNotNull('editorials.deleted_at');
                break;
            }
            case 'all':
            {
                $editorials = DB::table('editorials');
                break;
            }
            default:
            {
                $editorials = DB::table('editorials')->whereNull('editorials.deleted_at');
                break;
            }
        }
        if(!isset($this->currentUserRole))
        {
            $this->currentUserRole = ManagementController::userTeam();
        }
        switch($this->currentUserRole->role)
        {
            case 'sysadmin':
            {
                $editorials->select('editorials.*', 'organisations.id as organisation_id', 'organisations.title as organisation_title')->join('organisations', 'organisation_id', '=', 'organisations.id');
                break;
            }
/*            case 'groupadmin':
            {
                $editorials->select('editorials.*', 'organisations.id as organisation_id', 'organisations.title as organisation_title')->join('organisations', 'organisation_id', '=', 'organisations.id')
                    ->join('teams', function (JoinClause $join) 
                    {
                        $join->on('team_id', '=', 'teams.id')
                         ->where('team_id', '=', $this->currentUserRole->team_id);
                    });
                unset($listFields['team_name']);
                break;
            }*/
        }
        $orderBy = session()->get('editorialOrderBy');
        if(isset($this->orderBy))
        {
            if(isset($orderBy))
            {
                if($this->orderBy === $orderBy['field'])
                {
                    if($orderBy['sort'] === 'asc')
                    {
                        $orderBy['sort'] = 'desc';
                    }
                    else
                    {
                        $orderBy['sort'] = 'asc';
                    }
                }
                else
                {
                    $orderBy = 
                    [
                        'field' => $this->orderBy,
                        'sort' => 'asc'
                    ];
                }
            }
            else
            {
                $orderBy = 
                [
                    'field' => $this->orderBy,
                    'sort' => 'asc'
                ];
            }
            session(['editorialOrderBy' => $orderBy]);
            unset($this->orderBy);

        }
        if(isset($orderBy))
        {
            $editorials->orderBy($orderBy['field'],  $orderBy['sort']);
        }
        $viewData = 
        [
            'countOfRecords' => $editorials->count(),
            'listFields' => $listFields,
            'editFields' => $editFields,
            'orderBy' => $orderBy,
        ];
        $viewData['countOfSites'] = ceil($viewData['countOfRecords'] / $this->rowPerPage);
        if($viewData['countOfSites'] < $this->currentPage)
        {
            $this->currentPage = $viewData['countOfSites'];
        }
        $rowOffset = ($this->currentPage - 1) * $this->rowPerPage;

        $viewData['editorials'] = $editorials->offset($rowOffset)->limit($this->rowPerPage)->get()->toArray();
        $viewData['currentPage'] = $this->currentPage;
        $viewData['firstRecord'] = $rowOffset + 1;
        $viewData['lastRecord'] = $this->currentPage * $this->rowPerPage;
        if($viewData['countOfRecords'] < $viewData['lastRecord'])
        {
            $viewData['lastRecord'] = $viewData['countOfRecords'];
        }
        return $viewData;
    }
    public function mount()
    {
        if(session()->has('editorialShowRecords'))
        {
            $this->showRecords = session()->get('editorialShowRecords');
        }
        if(session()->has('editorialCurrentPage'))
        {
            $this->currentPage = session()->get('editorialCurrentPage');
        }
        if(session()->has('editorialRowPerPage'))
        {
            $this->rowPerPage = session()->get('editorialRowPerPage');
        }
    }
    public function render(Request $req)
    {
        $viewData = $this->list($req);
        return view('livewire.management.editorial', $viewData);
    }
    public function setPagination()
    {
        session(['editorialCurrentPage' => $this->currentPage]);
        $this->setSession = true;
    }
    public function setRecordFilter()
    {
        session(['editorialShowRecords' => $this->showRecords]);
        $this->setSession = true;
    }
    public function setRowPerPage()
    {
        session(['editorialRowPerPage'=> $this->rowPerPage]);
        $this->setSession = true;
    }
    public function sort($field)
    {
        $this->orderBy = $field;
    }
    public function undelete($id)
    {
        editorialModel::withTrashed()->where('id', $id)->restore();
    }
    public function update($id)
    {
        $currentRecord = editorialModel::withTrashed()->find($id);
        if(isset($currentRecord))
        {
            foreach($this->modelFields as $field => $none)
            {
                switch($field)
                {
                    case 'id':
                    {
                        break;
                    }
                    case 'logo':
                    case 'logo_for_light_bg':
                    case 'logo_for_dark_bg':
                    {
                        if(isset($images->$field))
                        {
                            $currentRecord->$field = $images->$field;
                        }
                        break;
                    }
                    default:
                    {
                        $editField = $field.'Edit';
                        $currentRecord->$field = $this->$editField;
                    }
                }
            }
            $currentRecord->save();
            unset($this->idEdit);
        }
    }   # end of update
}

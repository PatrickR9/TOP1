<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Userrole as userRoleModel;
use Illuminate\Support\Facades\DB;
use Schema;

class UserRole extends Component
{
    # input fields of the table
    public $id;
    public $name;
    public $type;

    # id fields
    public $idDelete;
    public $idEdit;
    public $idInsert;

    # input fields of the table to edit
    public $nameEdit;
    public $typeEdit;

    # sorting fields
    private $orderBy;

    # attribs
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
        'name' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Name',
            'list' => true
        ],
       'type' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Typ',
            'list' => true
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
            $currentUserRole = userRoleModel::find($this->idDelete);
            if(isset($currentUserRole))
            {
                $currentUserRole->delete();
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
        }
        else
        {
            $editedRecord = userRoleModel::find($id)->toArray();
            foreach($editedRecord as $fieldName => $value)
            {
                if(!in_array($fieldName, $this->editDisabled) && isset($this->modelFields[$fieldName]))
                {
                    $editFieldName = $fieldName.'Edit';
                    $this->$editFieldName = $value;
                }
            }
        }
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
        $userRoleModel = userRoleModel::create($dataArray);
        unset($this->idInsert);
    }

    private function list()
    {
        $tableFields = Schema::getColumnListing('userroles');
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
                $editFields[$field] = $this->modelFields[$field];
            }
        }
        switch($this->showRecords)
        {
            case 'deletedRecords':
            {
                $userroles = DB::table('userroles')->whereNotNull('userroles.deleted_at');
                break;
            }
            case 'all':
            {
                $userroles = DB::table('userroles');
                break;
            }
            default:
            {
                $userroles = DB::table('userroles')->whereNull('userroles.deleted_at');
                break;
            }
        }
        
        $orderBy = session()->get('userrolesOrderBy');
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
            session(['userrolesOrderBy' => $orderBy]);
            unset($this->orderBy);

        }
        if(isset($orderBy))
        {
            $userroles->orderBy($orderBy['field'],  $orderBy['sort']);
        }
        $viewData = 
        [
            'countOfRecords' => $userroles->count(),
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

        $viewData['userroles'] = $userroles->offset($rowOffset)->limit($this->rowPerPage)->get()->toArray();
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
        if(session()->has('userrolesShowRecords'))
        {
            $this->showRecords = session()->get('userrolesShowRecords');
        }
        if(session()->has('userrolesCurrentPage'))
        {
            $this->currentPage = session()->get('userrolesCurrentPage');
        }
        if(session()->has('userrolesRowPerPage'))
        {
            $this->rowPerPage = session()->get('userrolesRowPerPage');
        }
    }

    public function render()
    {
        $viewData = $this->list();
        return view('livewire.management.user-role', $viewData);
    }

    public function setPagination()
    {
        session(['userrolesCurrentPage' => $this->currentPage]);
        $this->setSession = true;
    }

    public function setRecordFilter()
    {
        session(['userrolesShowRecords' => $this->showRecords]);
        $this->setSession = true;
    }

    public function setRowPerPage()
    {
        session(['userrolesRowPerPage'=> $this->rowPerPage]);
        $this->setSession = true;
    }

    public function sort($field)
    {
        $this->orderBy = $field;
    }

    public function undelete($id)
    {
        userRoleModel::withTrashed()->where('id', $id)->restore();
    }

    public function update($id)
    {
        $currentRecord = userRoleModel::find($id);
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
    }
}

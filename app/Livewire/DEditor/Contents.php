<?php

namespace App\Livewire\DEditor;

use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ContentController;
use Livewire\Component;
use Schema;

class Contents extends Component
{
    public $contents;
    public $viewData;

    # sorting fields
    public $orderBy;

    # attribs
    private $currentUserRole;
    public $currentPage = 1;
    public $rowPerPage = 5;
    public $showRecords = 'notDeletedRecords';
    public $teamOptions;


    public function mount()
    {
        $this->reload();
    }
    private function reload()
    {
        $tableFields = Schema::getColumnListing('organisations');
        $editFields = [];
        $listFields = [];
        switch($this->showRecords)
        {
            case 'deletedRecords':
            {
                $contents = DB::table('contents')->whereNotNull('deleted_at');
                break;
            }
            case 'all':
            {
                $contents = DB::table('contents');
                break;
            }
            default:
            {
                $contents = DB::table('contents')->whereNull('deleted_at');
                break;
            }
        }
        $this->currentUserRole = ManagementController::userTeam();
        switch($this->currentUserRole->role)
        {
            case 'sysadmin':
            {
                $contents->select('contents.*');//, 'teams.name as team_name')->join('teams', 'team_id', '=', 'teams.id');
                break;
            }
            case 'groupadmin':
            {
                $contents->where('team_id', $this->currentUserRole->team_id);
                break;
            }
        }
        foreach($tableFields as $field)
        {
            if(isset($this->modelFields[$field]))
            {
                if($this->modelFields[$field]['list'] === true)
                {
                    $listFields[$field] = $this->modelFields[$field]['label'];
                }
                if($field === 'team_id')
                {
                    if($this->currentUserRole->role === 'sysadmin')
                    {
                        $listFields['team_name'] = $this->modelFields[$field]['label'];
                    }
                }
                else
                {
                    $editFields[$field] = $this->modelFields[$field];
                }
            }
            $filterField = $field.'Filter';
            if(($filterField === 'team_idFilter') && count($this->teamFilteredIds) > 0)
            {
                $organisations->whereRaw('team_id in ('.implode(',', $this->teamFilteredIds).')');
            }
            elseif(isset($this->$filterField) && ($this->$filterField !== ''))
            {
                $organisations->where($field, 'like', '%'.$this->$filterField.'%');
            }
        }
        if(isset($this->orderBy))
        {
            $organisations->orderBy($this->orderBy['field'],  $this->orderBy['sort']);
        }
        $this->viewData = 
        [
            'countOfRecords' => $organisations->count(),
            'editFields' => $editFields,
            'listFields' => $listFields
        ];
        $this->viewData['countOfSites'] = intval(ceil($this->viewData['countOfRecords'] / $this->rowPerPage));
        if($this->viewData['countOfSites'] < $this->currentPage)
        {
            $this->currentPage = $this->viewData['countOfSites'];
        }
        $rowOffset = ($this->currentPage - 1) * $this->rowPerPage;
        $this->viewData['organisations'] = $organisations->offset($rowOffset)->limit($this->rowPerPage)->get()->toArray();
        $this->viewData['firstRecord'] = $rowOffset + 1;
        $this->viewData['lastRecord'] = $this->currentPage * $this->rowPerPage;
        if($this->viewData['countOfRecords'] < $this->viewData['lastRecord'])
        {
            $this->viewData['lastRecord'] = $this->viewData['countOfRecords'];
        }
    }
    public function render(Request $req)
    {
        return view('livewire.d-editor.contents');
    }
}

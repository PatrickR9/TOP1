<?php

namespace App\Livewire\Management;

use App\Http\Classes\Crm;
use App\Http\Controllers\ManagementController;
use App\Models\MediapoolCategory;
use App\Models\Organisation as orgModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
#use Livewire\WithFileUploads;
use Schema;

class Organisation extends Component
{
 #   use WithFileUploads;

    # input fields of the table
    public $id;
    public $title;
    public $short_title;
    public $street;
    public $zip;
    public $city;
    public $country;
    public $email;
    public $website;
    public $logo;
    public $logo_for_light_bg;
    public $logo_for_dark_bg;
    public $cd_colors;
    
    # id fields
    public $idDelete;
    public $idEdit;
    public $idInsert;

    # input fields of the table to edit
    public $titleEdit;
    public $short_titleEdit;
    public $streetEdit;
    public $zipEdit;
    public $cityEdit;
    public $countryEdit;
    public $emailEdit;
    public $websiteEdit;
    public $logoEdit;
    public $logo_for_light_bgEdit;
    public $logo_for_dark_bgEdit;
    public $cd_colorsEdit;
    
    # input fields to filter
    public $teamFilteredIds = [];
    public $team_nameFilter = '';
    public $titleFilter;
    public $short_titleFilter;
    public $streetFilter;
    public $zipFilter;
    public $cityFilter;
    public $countryFilter;
    public $emailFilter;
    public $websiteFilter;

    # sorting fields
    public $orderBy;

    # attribs
    private $currentUserRole;
    public $currentPage = 1;
    public $rowPerPage = 5;
    public $showRecords = 'notDeletedRecords';
    public $teamOptions = [];

    # controls and listeners 
    protected $listeners = 
    [
        'setFormMedium' => 'setFormMedium'
    ];
    private $editDisabled =
    [
        'team_id'
    ];
    private $modelFields = 
    [
        'id' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "hidden"',
            'label' => 'ID',
            'list' => false,
        ],
        'team_id' =>
        [
            'label' => 'Team',
            'list' => false,
        ],
        'title' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Titel',
            'list' => true,
        ],
       'short_title' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text"',
            'label' => 'Kurztitel',
            'list' => false,
        ],
        'street' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Strasse, Haus-Nr.',
            'list' => false,
        ],
        'zip' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_short"',
            'label' => 'PLZ',
            'list' => true,
        ],
        'city' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text"',
            'label' => 'Ort',
            'list' => true,
        ],
        'country' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text"',
            'label' => 'Land',
            'list' => true,
        ],
        'email' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "email" class = "input_long"',
            'label' => 'E-Mail',
            'list' => true,
        ],
        'website' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Webseite',
            'list' => false,
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
    public function clearRecordFilter($filterField)
    {
        if(isset($this->$filterField))
        {
            switch($filterField)
            {
                case 'teamFilteredIds':
                {
                    $this->$filterField = [];
                    break;
                }
                default:
                {
                    $this->$filterField = '';
                    break;
                }
            }
        }
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
            $currentOrganisation = orgModel::find($this->idDelete);
            if(isset($currentOrganisation))
            {
                $currentOrganisation->delete();
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
            $editedRecord = orgModel::withTrashed()->find($id)->toArray();
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
        $this->currentUserRole = ManagementController::userTeam();
        $dataArray = 
        [
            'team_id' => $this->currentUserRole->team_id
        ];
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
        $orgModel = orgModel::create($dataArray);
        if(isset($orgModel))
        {
            $storagePath = 'protected';
            Crm::checkStoreDirectory($storagePath);
            $storagePath .= '/'.$orgModel->id;
            Crm::checkStoreDirectory($storagePath);
            $mediapoolCategory = new MediapoolCategory();
            $mediapoolCategory->organisation_id = $orgModel->id;
            $mediapoolCategory->name = '';
            $mediapoolCategory->save();
        }
        unset($this->idInsert);
    }   # end of insert
    private function list($req)
    {
        $tableFields = Schema::getColumnListing('organisations');
        $editFields = [];
        $listFields = [];
        switch($this->showRecords)
        {
            case 'deletedRecords':
            {
                $organisations = DB::table('organisations')->whereNotNull('deleted_at');
                break;
            }
            case 'all':
            {
                $organisations = DB::table('organisations');
                break;
            }
            default:
            {
                $organisations = DB::table('organisations')->whereNull('deleted_at');
                break;
            }
        }
        $this->currentUserRole = ManagementController::userTeam();
        switch($this->currentUserRole->role)
        {
            case 'sysadmin':
            {
                $organisations->select('organisations.*', 'teams.name as team_name')->join('teams', 'team_id', '=', 'teams.id');
                break;
            }
            case 'groupadmin':
            {
                $organisations->where('team_id', $this->currentUserRole->team_id);
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
        $viewData = 
        [
            'countOfRecords' => $organisations->count(),
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
        $viewData['organisations'] = $organisations->offset($rowOffset)->limit($this->rowPerPage)->get()->toArray();
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
    public function mediaPool($field)
    {
        $this->dispatch('openPool', ['dispatch' => 'setFormMedium', 'source' => 'protected', 'id' => $this->idEdit, 'target' => $field]);
        $this->skipRender();
    }
    public function mount()
    {
        $this->currentUserRole = ManagementController::userTeam();
        $organisations = orgModel::select('team_id', 'teams.name as team_name')->distinct()->join('teams', 'team_id', '=', 'teams.id');
        switch($this->currentUserRole->role)
        {
            case 'sysadmin':
            {
                break;
            }
            case 'groupadmin':
            {
                $organisations->where('team_id', $this->currentUserRole->team_id);
                break;
            }
        }
        if(session()->has('organisationOrderBy'))
        {
            $this->orderBy = session()->get('organisationOrderBy');
        }
        # init filters
        $teamData = $organisations->orderBy('team_name', 'asc')->get()->toArray();
        foreach($teamData as $teamRow)
        {
            $this->teamOptions[$teamRow['team_id']] = $teamRow['team_name'];
        }
        if(session()->has('organisationShowRecords'))
        {
            $this->showRecords = session()->get('organisationShowRecords');
        }
        if(session()->has('organisationCurrentPage'))
        {
            $this->currentPage = session()->get('organisationCurrentPage');
        }
        if(session()->has('organisationRowPerPage'))
        {
            $this->rowPerPage = session()->get('organisationRowPerPage');
        }
        if(session()->has('organisationFilters'))
        {
            $organisationFilters = session()->get('organisationFilters');
            foreach($organisationFilters as $filterField => $filterValue)
            {
                $this->$filterField = $filterValue;
            }
        }
    }
    public function paginate()
    {
        session(['organisationCurrentPage' => $this->currentPage]);
    }
    public function render(Request $req)
    {
        $viewData = $this->list($req);
        return view('livewire.management.organisation', $viewData);
    }
    public function setFormMedium($media)
    {
        foreach($media as $field => $src)
        {
            $this->$field = $src;
        }
    }
    public function setPagination()
    {
        session(['organisationCurrentPage' => $this->currentPage]);
    }
    public function setRecordFilter()
    {
        session(['organisationShowRecords' => $this->showRecords]);
        $this->teamFilteredIds = [];
        $teamFilteredIds = DB::table('teams')->select('id')->where('name', 'like' , $this->team_nameFilter)->get()->toArray();
        foreach($teamFilteredIds as $teamFilteredId)
        {
            $this->teamFilteredIds[] = $teamFilteredId->id;
        }
        session(['organisationFilters' => 
            [
                'teamFilteredIds' => $this->teamFilteredIds,
                'team_nameFilter' => $this->team_nameFilter,
                'titleFilter' => $this->titleFilter,
                'short_titleFilter' => $this->short_titleFilter,
                'streetFilter' => $this->streetFilter,
                'zipFilter' => $this->zipFilter,
                'cityFilter' => $this->cityFilter,
                'countryFilter' => $this->countryFilter,
                'emailFilter' => $this->emailFilter,
                'websiteFilter' => $this->websiteFilter
            ]
        ]);
    }
    public function setRowPerPage()
    {
        session(['organisationRowPerPage'=> $this->rowPerPage]);
    }
    public function sort($field)
    {
        if(isset($this->orderBy))
        {
            if($this->orderBy['field'] === $field)
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
            else
            {
                $this->orderBy = 
                [
                    'field' => $field,
                    'sort' => 'asc'
                ];
            }
        }
        else
        {
            $this->orderBy = 
            [
                'field' => $field,
                'sort' => 'asc'
            ];
        }
        session(['organisationOrderBy' => $this->orderBy]);
    }
    public function undelete($id)
    {
        orgModel::withTrashed()->where('id', $id)->restore();
    }
    public function update($id)
    {
        $images = Crm::writeMedia('organisations', $id, ['logo' => $this->logoEdit, 'logo_for_light_bg' => $this->logo_for_light_bgEdit, 'logo_for_dark_bg' => $this->logo_for_dark_bgEdit]);
        $currentRecord = orgModel::withTrashed()->find($id);
        if(isset($currentRecord))
        {
            foreach($this->modelFields as $field => $none)
            {
                switch($field)
                {
                    case 'id':
                    case 'team_id':
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

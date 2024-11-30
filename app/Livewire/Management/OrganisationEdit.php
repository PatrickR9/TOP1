<?php

namespace App\Livewire\Management;

use App\Http\Classes\Crm;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MediaController;
use App\Models\Editorial;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class OrganisationEdit extends Component
{
    public $id;             # organistion id 
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
    
    # attribs
    public $selectedTab;
    public $tabs =
    [
        'overview' =>
        [
            'label' => 'Übersicht'
        ],
        'organisation' =>
        [
            'label' => 'Verband'
        ]
    ];
    protected $listeners = 
    [
        'setOrganisationMedium' => 'setOrganisationMedium'
    ];

    private function getOrganisation($queryType = 'overview')
    {
        $currentUserRole = ManagementController::userTeam();
        $organisationTable = DB::table('organisations');
        switch($queryType)
        {
            case 'full':
            {
                $organisationTable->select('id','title','short_title','street','zip','city','country','email','website','logo','logo_for_light_bg','logo_for_dark_bg','cd_colors', DB::raw('DATE_FORMAT(created_at, "%d.%m.%Y %H:%i:%s") as created_at, DATE_FORMAT(updated_at, "%d.%m.%Y %H:%i:%s") as updated_at, (deleted_at is null) as active'));
                break;
            }
            case 'overview':
            {
                $organisationTable->select('id', 'title', 'short_title', 'street', 'zip', 'city', 'country', 'email', 'website', DB::raw('(deleted_at is null) as active'));
                break;
            }
        }
        $organisationTable->where('id', $this->id);
        if($currentUserRole->role === 'groupadmin')
        {
            $organisationTable->where('team_id', $currentUserRole->team_id);
        }
        $currentOrganisation = $organisationTable->get()->toArray();
        if(count($currentOrganisation) === 1)
        {
            return $currentOrganisation[0];
        }
        else
        {
            return null;
        }
    }
    public function mediaPool($targetInputId, $types = 'all')
    {
        /*dump($targetInputId);
        dump($types);/** */
        $this->dispatch('openPool', ['dispatch' => 'setOrganisationMedium', 'source' => 'organisations', 'id' => $this->id, 'target' => $targetInputId, 'types' => $types]); /**/
    }
    public function mount()
    {
        session()->forget('organisationMedia');
    }
    private function organisation()
    {
        $tableFields = Schema::getColumnListing('organisations');
        $viewParams = 
        [
            'organisationFields' => new \stdClass()
        ];
        foreach($tableFields as $tableField)
        {
            if(isset($this->$tableField))
            {
                $viewParams['organisationFields']->$tableField = $this->$tableField;
            }
        }
        $currentOrganisation = $this->getOrganisation('full');
        if(session()->has('organisationMedia'))
        {
            if(isset($currentOrganisation))
            {
                $cOrgaArray = get_object_vars($currentOrganisation);
                foreach($cOrgaArray as $field => $value)
                {
                    if(property_exists($this, $field))
                    {
                        $this->$field = $value;
                        $viewParams['organisationFields']->$field = $value;
                    }
                }
            }
            $mediaFromPool = session()->get('organisationMedia');
            foreach($mediaFromPool as $target => $media)
            {
                if(property_exists($this, $target))
                {
                    $this->$target = $media;
                    $viewParams['organisationFields']->$target = $media;
                }
            }
        }
        else
        {
            $mediaFromPool = [];
            if(isset($currentOrganisation))
            {
                $cOrgaArray = get_object_vars($currentOrganisation);
                foreach($cOrgaArray as $field => $value)
                {
                    if(property_exists($this, $field))
                    {
                        $this->$field = $value;
                        $viewParams['organisationFields']->$field = $value;
                        if(in_array($field, ['logo', 'logo_for_light_bg', 'logo_for_dark_bg']))
                        {
                            $mediaFromPool[$field] = $value;
                        }
                    }
                }
                session(['organisationMedia' => $mediaFromPool]);
            }
            else
            {
                $viewParams['recordDisabled'] = true;
            }
        }
        return  $viewParams;
    }
    private function overview()
    {
        $currentOrganisation = $this->getOrganisation();
        if(isset($currentOrganisation))
        {
            $viewParams = 
            [
                'currentOrganisation' => $currentOrganisation,
                'currentOrganisationEditorials' => Editorial::withTrashed()->select('id', 'title')->where('organisation_id', $this->id)->orderBy('title')->get()
            ];
        }
        else
        {
            $viewParams['recordDisabled'] = true;
        }
        return  $viewParams;
    }
    public function removeImage($target)
    {
        $mediaFromPool = session()->get('organisationMedia');
        $mediaFromPool[$target] = null;
        session(['organisationMedia' => $mediaFromPool]);
    }
    public function reload()
    {
        # render the original data
        session()->forget('organisationMedia');
    }
    public function render(Request $req)
    {
        if($req->has('id'))
        {
            $this->id = $req->get('id');
        }
        if(session()->has('organisationSelectedTab'))
        {
            $selectedTab = session()->get('organisationSelectedTab');
        }
        else
        {
            $selectedTab = 'overview';
        }
        if(!method_exists($this, $selectedTab))
        {
            $selectedTab = 'overview';
        }
        $this->selectedTab = $selectedTab;
        $viewParams = $this->$selectedTab($req);
        if(isset($viewParams['recordDisabled']))
        {
            return view('livewire.management.organisation-error', $viewParams);
        }
        else
        {
            return view('livewire.management.organisation-edit', $viewParams);
        }
    }
    public function selectTab($tabId)
    {
        session(['organisationSelectedTab' => $tabId]);
    }
    public function setOrganisationMedium($params)
    {
        $mediaFromPool = session()->get('organisationMedia');
        foreach($params as $target => $file)
        {
            $mediaFromPool[$target] = $file;
        }
        session(['organisationMedia' => $mediaFromPool]);
    }
    public function update($id)
    {
        $images = Crm::writeMedia('organisation', $id, ['logo' => $this->logo, 'logo_for_light_bg' => $this->logo_for_light_bg, 'logo_for_dark_bg' => $this->logo_for_dark_bg]);
        $currentRecord = Organisation::withTrashed()->find($id);
        if(isset($currentRecord))
        {
            $currentRecordArray = $currentRecord->toArray();
            foreach($currentRecordArray as $field => $none)
            {
                if(property_exists($this, $field))
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
                            else
                            {
                                $currentRecord->$field = '';
                            }
                            break;
                        }
                        default:
                        {
                            $currentRecord->$field = $this->$field;
                        }
                    }
                }
            }
            $currentRecord->save();
        }
        session()->forget('organisationMedia');
    }   # end of update
}

<?php

namespace App\Livewire\Management;

use App\Models\User;
use App\Models\Uservalue;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Attributes\Validate; 
use App\Models\Userrole;
use App\Models\User2role;
use App\Models\EditorialMember;

class UserEdit extends Component
{
    public $id;
//    #[Validate(['required','unique:users,name', 'max:255'])] 
    public $name;
//    #[Validate(['required','email','unique:users,email', 'max:510'])] 
    public $email;
//    #[Validate(['regex:/[^A-Za-zÄÖÜäöüß\'\-\ ]/'])]
    public $firstname;
/*    #[Validate('required|email')] */
    public $lastname;
    public $street;
    public $zip;
    public $city;
    public $country;
    public $birthdate;
    public $website;

    # attribs
    public $selectedTab;
    public $selectedUserRoles = [];
    public $tabs =
    [
        'overview' =>
        [
            'label' => 'Übersicht'
        ],
        'user' =>
        [
            'label' => 'Benutzer'
        ],
        'userroles' =>
        [
            'label' => 'Benutzerrollen'
        ]
    ];
    private function overview($req)
    {
        if($req->has('id'))
        {
            $currentUserId = $req->get('id');
        }
        else
        {
            $currentUserId = $this->id;
        }
        $currentUser = User::find($currentUserId);
        if(isset($currentUser))
        {
            $currentUserArray = $currentUser->toArray();
            $currentUserTeams = array_merge($currentUser->ownedTeams->toArray(), $currentUser->teams->toArray());
            $currentUserTeamData = [];
            foreach($currentUserTeams as $currentUserTeam)
            {
                $currentUserTeamData[$currentUserTeam['id']] = new \stdClass();
                $currentUserTeamData[$currentUserTeam['id']]->name = $currentUserTeam['name'];
                if(isset($currentUserTeam['membership']))
                {
                    $currentUserTeamData[$currentUserTeam['id']]->membership = $currentUserTeam['membership'];
                }
            }
            $viewParams = 
            [
                'currentUser' => $currentUserArray,
                'currentUserTeams' => $currentUserTeams,
                'currentUserTeamData' => $currentUserTeamData,
                'currentUserOrganisations' => Organisation::withTrashed()->select('id', 'title', 'team_id')->whereRaw('team_id in ('.implode(',', array_keys($currentUserTeamData)).')')->orderBy('title')->get(),
                'currentUserUserRoles' => $currentUser->user2roles()
                    ->with(['userrole' => function ($query) {
                        $query->orderBy('name', 'asc');
                    }])
                    ->get()
                    ->pluck('userrole'),
                'currentUserEditorials' => $currentUser->editorialMembers()
                    ->with(['editorial' => function ($query) {
                        $query->orderBy('title', 'asc');
                    }])
                    ->get()
                    ->pluck('editorial')
            ];
        }
        else
        {
            $viewParams['recordDisabled'] = true;
        }
        return $viewParams;
    }
    public function render(Request $req)
    {
        if($req->has('id'))
        {
            $this->id = $req->get('id');
        }
        if(session()->has('userSelectedTab'))
        {
            $selectedTab = session()->get('userSelectedTab');
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
            return view('livewire.management.user-error', $viewParams);
        }
        else
        {
            return view('livewire.management.user-edit', $viewParams);
        }
    }
    public function selectTab($tabId)
    {
        session(['userSelectedTab' => $tabId]);
    }
    public function update($uId)
    {
       
        $validateParams = [];
        $currentUser = User::find($uId);
        if(isset($currentUser))
        {
            $currentUserUpdates = [];
            if(trim($currentUser->name) !== trim($this->name))
            {
                $validateParams['name'] = ['required','unique:users,name', 'max:255'];
                $currentUserUpdates[] = 'name';
            }
            if(trim($currentUser->email) !== trim($this->email))
            {
                $validateParams['email'] = ['required','email','unique:users,email', 'max:510'];
                $currentUserUpdates[] = 'email';
            }
            $validateParams['firstname'] = ['nullable', "regex:/^[A-Za-zÄÖÜäöüß\'\-\ ]*$/"];
            $validateParams['lastname'] = ['nullable', "regex:/^[A-Za-zÄÖÜäöüß\'\-\ ]*$/"];
            $validateParams['street'] = ['nullable', "regex:/^[0-9A-Za-zÄÖÜäöüß\'\-\ \/\.#]*$/"];
            $validateParams['zip'] = ['nullable', "regex:/^[0-9A-Za-zÄÖÜäöüß\-]*$/"];
            $validateParams['city'] = ['nullable', "regex:/^[0-9A-Za-zÄÖÜäöüß\'\-\ \/\.]*$/"];
            $validateParams['birthdate'] = ['date', 'nullable', 'before:today'];
            $this->validate($validateParams);
            unset($validateParams['name']);
            unset($validateParams['email']);
            if(count($currentUserUpdates) > 0)
            {
                foreach($currentUserUpdates as $index)
                {
                    $currentUser->$index = $this->$index;
                }
                $currentUser->save();
            }
            if(!isset($currentUser->uservalue))
            {
                $currentUser->uservalue = new Uservalue();
                $currentUser->uservalue->user_id=$uId;
            }
            foreach($validateParams as $index => $none)
            {
                $currentUser->uservalue->$index = $this->$index;
            }
            $currentUser->uservalue->save();
        }
    }
    public function user()
    {
        $viewParams = [];
        $currentUser = User::find($this->id);
        if(isset($currentUser))
        {
            $this->name = $currentUser->name;
            $this->email = $currentUser->email;
            $this->profile_photo_path = $currentUser->profile_photo_path;
            $this->profile_photo_url = $currentUser->profile_photo_url;
            if(isset($currentUser->uservalue))
            {
                $this->firstname = $currentUser->uservalue->firstname;
                $this->lastname = $currentUser->uservalue->lastname;
                $this->street = $currentUser->uservalue->street;
                $this->zip = $currentUser->uservalue->zip;
                $this->city = $currentUser->uservalue->city;
                $this->country = $currentUser->uservalue->country;
                $this->birthdate = $currentUser->uservalue->birthdate;
                $this->website = $currentUser->uservalue->website;
            }
            $viewParams = 
            [
                'currentUser' => $currentUser,
            ];
        }
        return $viewParams;
    }

    public function userroles()
    {
        $viewParams = [];
        $currentUser = User::find($this->id);

        $allRoles = Userrole::orderBy('name', 'asc')->get(['id', 'name']);

        $currentUserRoleIds = $currentUser->user2roles()->pluck('userrole_id')->toArray();
        $this->selectedUserRoles = array_values($currentUserRoleIds);

        $viewParams =
            [
                'allRoles' => $allRoles
            ];

        return $viewParams;
    }

    public function updateUserRoles()
    {
        $this->selectedUserRoles = array_map('intval', $this->selectedUserRoles);

        $this->addOrRemoveUserRoles($this->id, $this->selectedUserRoles);
    }

    private function addOrRemoveUserRoles($userId, $newRoleIds)
    {
        $existingRoleIds = User2role::where('user_id', $userId)->pluck('userrole_id')->toArray();

        $rolesToAdd = array_diff($newRoleIds, $existingRoleIds);
        $rolesToRemove = array_diff($existingRoleIds, $newRoleIds);

        foreach ($rolesToAdd as $roleId) {
            User2Role::create([
                'user_id' => $userId,
                'userrole_id' => $roleId,
            ]);
        }

        if (!empty($rolesToRemove)) {
            User2Role::where('user_id', $userId)
                ->whereIn('userrole_id', $rolesToRemove)
                ->delete();
        }
    }
}

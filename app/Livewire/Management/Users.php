<?php

namespace App\Livewire\Management;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class Users extends Component
{
    public $listFields = 
    [
        'id' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "hidden"',
            'label' => 'ID',
            'list' => false,
        ],
        'name' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Benutzername',
            'list' => true,
        ],
        'email' => 
        [
            'tag' => 'input',
            'attribs' => 'type = "eamil" class = "input_long"',
            'label' => 'E-Mail',
            'list' => true,
        ],
        'user_role' =>
        [
            'tag' => 'input',
            'attribs' => 'type = "text" class = "input_long"',
            'label' => 'Benutzerrollen',
            'list' => true,
        ],
        'team_name' =>
        [
            'label' => 'Teambesitzer',
            'list' => true,
        ]
    ];
    public $orderBy;
    public $userList;

    private function list()
    {
        if(!session()->has('usersOrderBy'))
        {
            session(['usersOrderBy' => ['field' => 'team_owner', 'sort' => 'asc']]);
        }
        $this->orderBy = session()->get('usersOrderBy');
        $this->userList = User::select('users.*', DB::raw('(current_team_id is not null) as team_owner'), 'teams.name as team_name')->join('teams', 'current_team_id', '=', 'teams.id')->with(['user2roles.userrole'])->orderBy($this->orderBy['field'], $this->orderBy['sort'])->get();
    }
    public function mount()
    {
        session()->forget('usersOrderBy');
    }
    public function render()
    {
        if(!isset($this->userList))
        {
            $this->list();
        }
        return view('livewire.management.users');
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
        session(['usersOrderBy' => $this->orderBy]); 
        $this->list();
    }   
}

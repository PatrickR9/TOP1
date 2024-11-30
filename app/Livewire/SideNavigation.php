<?php

namespace App\Livewire;

use App\Http\Controllers\ManagementController;
use Livewire\Component;

class SideNavigation extends Component
{
    public $currentStatus;
    public $currentUrl;
    public $naviType = 'admin';
    public $links;

    public function mediaPool()
    {
        $this->dispatch('openPool', ['dispatch' => 'none', 'source' => 'public', 'id' => 'root']);
    }
    public function render()
    {
        $this->currentUrl = explode(request()->getHost(), url()->current())[1];
        $this->links = [];
        $currentUserRole = ManagementController::userTeam();
        switch($currentUserRole->role)
        {
            case 'sysadmin':
            {
                $this->links = 
                [
                    'Benutzer' => 
                    [
                        'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>',
                        'links' =>
                        [
                            [
                                'url' => '/users',
                                'label' => 'Benutzer'
                            ],
                            [
                                'url' => '/user_roles',
                                'label' => 'Benutzerrollen'
                            ],
                        ]
                    ],
                    'Einheiten' => 
                    [
                        'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M400-400h160v-80H400v80Zm0-120h320v-80H400v80Zm0-120h320v-80H400v80Zm-80 400q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z"/></svg>',
                        'links' =>
                        [
                            [
                                'url' => '/contents',
                                'label' => 'Alle Einheiten',
                            ],
                            [
                                'label' => 'Medien',
                                'wire:click' => 'mediaPool()'
                            ],
                        ],
                    ],
                    'Die Bibel' =>
                    [
                        'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M260-320q47 0 91.5 10.5T440-278v-394q-41-24-87-36t-93-12q-36 0-71.5 7T120-692v396q35-12 69.5-18t70.5-6Zm260 42q44-21 88.5-31.5T700-320q36 0 70.5 6t69.5 18v-396q-33-14-68.5-21t-71.5-7q-47 0-93 12t-87 36v394Zm-40 118q-48-38-104-59t-116-21q-42 0-82.5 11T100-198q-21 11-40.5-1T40-234v-482q0-11 5.5-21T62-752q46-24 96-36t102-12q58 0 113.5 15T480-740q51-30 106.5-45T700-800q52 0 102 12t96 36q11 5 16.5 15t5.5 21v482q0 23-19.5 35t-40.5 1q-37-20-77.5-31T700-240q-60 0-116 21t-104 59ZM280-494Z"/></svg>',
                        'links' =>
                        [
                            [
                                'url' => '/bible',
                                'label' => 'Bibelstellen',
                            ],
                        ],
                    ],
                    'Seiten' => 
                    [
                        'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M280-160v-441q0-33 24-56t57-23h439q33 0 56.5 23.5T880-600v320L680-80H360q-33 0-56.5-23.5T280-160ZM81-710q-6-33 13-59.5t52-32.5l434-77q33-6 59.5 13t32.5 52l10 54h-82l-7-40-433 77 40 226v279q-16-9-27.5-24T158-276L81-710Zm279 110v440h280v-160h160v-280H360Zm220 220Z"/></svg>',
                        'links' =>
                        [
                            [
                                'url' => '/sites',
                                'label' => 'alle Seiten',
                            ]
                        ],
                    ],
                    'Verwaltung' =>
                    [
                        'icon' => '<svg class="menu_icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h240l80 80h320q33 0 56.5 23.5T880-640H447l-80-80H160v480l96-320h684L837-217q-8 26-29.5 41.5T760-160H160Zm84-80h516l72-240H316l-72 240Zm0 0 72-240-72 240Zm-84-400v-80 80Z"/></svg>',
                        'links' =>
                        [
                            [
                                'url' => '/organisations',
                                'label' => 'Verbände'
                            ],
                            [
                                'url' => '/authors',
                                'label' => 'Autorenverträge'
                            ],
                            [
                                'url' => '/editorials',
                                'label' => 'Redaktionen'
                            ],
                            [
                                'url' => '/aboversum',
                                'label' => 'Aboversum'
                            ]
                        ]
                    ]
                ];
                break;
            }
            case 'groupadmin':
            {
                $this->urls = 
                [
                    'content' => 
                    [
                        '/sites' => 'Seiten',
                    ],
                    'management' =>
                    [
                        '/organisations' => 'Verbände',
                        '/authors' => 'Autorenverträge',
                        '/editorials' => 'Redaktionen',
                        '/aboversum' => 'Aboversum'
                    ]
                ];
                break;
            }
            default:
            {
                $this->urls = 
                [
                    'content' => 
                    [
                        '/sites' => 'Seiten',
                    ],
                ];
                break;
            }
        }
        if(!session()->has('sideNavigationStatus'))
        {
            session(['sideNavigationStatus' => 'opened']);
        }
        $this->currentStatus = session()->get('sideNavigationStatus');
        return view('livewire.side-navigation');
    }
    public function snToggle($snStatus)
    {
        if($snStatus === 'opened')
        {
            session(['sideNavigationStatus' => 'closed']);
        }
        else
        {
            session(['sideNavigationStatus' => 'opened']);
        }
    }
}

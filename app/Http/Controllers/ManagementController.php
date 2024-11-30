<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    public function aboversum(Request $req)
    {
        $viewParams = [];
        return view('management.aboversum.index', $viewParams);
    }
    public function authors(Request $req)
    {
        echo "<p>".__FUNCTION__."</p>";
    }
    public function contents(Request $req, $id = null, $func = null)
    {
        $req->merge(['id' => $id]);
        $req->merge(['func' => $func]);
        switch($func)
        {
            case 'edit':
            {
                if(isset($id))
                {
                    $title = 'Einheit bearbeiten';
                }
                else
                {
                    $title = 'Neuer Einheit';
                }
                break;
            }
            default:
            {
                $title = 'Einheiten';
                break;
            }
        }
        $viewParams = 
        [
            'title' => $title,
            'add_class' => resolve('customer_role')
        ];
        return view('management.content.index', $viewParams);
    }
    public function editorials(Request $req, $id = null, $func = null)
    {
        $req->merge(['id' => $id]);
        $req->merge(['func' => $func]);
        switch($func)
        {
            case 'edit':
            {
                if(isset($id))
                {
                    $title = 'Redaktion bearbeiten';
                }
                else
                {
                    $title = 'Neue Redaktion';
                }
                break;
            }
            default:
            {
                $title = 'Redaktionen - Übersicht';
                break;
            }
        }
        $viewParams = 
        [
            'title' => $title,
            'add_class' => resolve('customer_role')
        ];
        return view('management.editorial.index', $viewParams);
    }
    public function organisation(Request $req, $id)
    {
        $req->merge(['id' => $id]);
        $viewParams = 
        [
            'title' => 'Edit - Verband',
            'add_class' => resolve('customer_role')
        ];
        return view('management.organisation.edit', $viewParams);
    }
    public function organisations(Request $req, $id = null, $func = null)
    {
        $req->merge(['id' => $id]);
        $req->merge(['func' => $func]);
        switch($func)
        {
            case 'edit':
            {
                if(isset($id))
                {
                    $title = 'Verband bearbeiten';
                }
                else
                {
                    $title = 'Neuer Verband';
                }
                break;
            }
            default:
            {
                $title = 'Verbände - Übersicht';
                break;
            }
        }
        $viewParams = 
        [
            'title' => $title,
            'add_class' => resolve('customer_role')
        ];
        return view('management.organisation.index', $viewParams);
    }
    public function sites(Request $req)
    {
        $viewParams = 
        [
            'title' => 'Seiten',
            'add_class' => resolve('customer_role')
        ];
        return view('d_editor.sites', $viewParams);
    }
    public function units(Request $req)
    {
        $viewParams = 
        [
            'title' => 'Einheiten',
            'add_class' => resolve('customer_role')
        ];
        return view('d_editor.units', $viewParams);
    }
    public function user(Request $req, $id)
    {
        $req->merge(['id' => $id]);
        $viewParams = 
        [
            'title' => 'Übersicht - '.User::select('name')->find($id)->name,
            'add_class' => resolve('customer_role')
        ];
        return view('management.users.edit', $viewParams);
    }
    public function users()
    {
        $currentTeamRole = self::userTeam();
        if($currentTeamRole->role === 'sysadmin')
        {
            $viewParams =
            [
                'title' => 'Benutzers',
                'add_class' => resolve('customer_role')
            ];
            return view('management.users.index', $viewParams);
        }
        else
        {
            return redirect('/');
        }
    }
    public static function userTeam()
    {
/*        $currentUser = Auth::user();
        $currentTeamRole = $currentUser->teamRole($currentUser->currentTeam)->key;
        switch($currentTeamRole)
        {
            case 'owner':
            {
                if($currentUser->currentTeam->id === intval(env('ADMIN_TEAM')))
                {
                    $customerRole = 'sysadmin';
                }
                else
                {
                    $customerRole = 'groupadmin';
                }
                break;
            }
            default:
            {
                if($currentUser->currentTeam->id == env('ADMIN_TEAM'))
                {
                    $customerRole = 'sys'.$currentTeamRole;
                }
                else
                {
                    $customerRole = 'group'.$currentTeamRole;
                }
                break;
            }
        }*/
        $customerRole = 'sysadmin';
        $currentUserRole = new \stdClass();
        $currentUserRole->user_id = 1;//$currentUser->id;
        $currentUserRole->team_id = 1;//$currentUser->currentTeam->id;
        $currentUserRole->role = $customerRole;
        return $currentUserRole;
    }
}

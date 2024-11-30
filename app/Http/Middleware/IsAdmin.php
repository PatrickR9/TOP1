<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user();
//        $adminTeam = Team::find(env('ADMIN_TEAM'));
//        $adminTeamRole = $currentUser->teamRole($adminTeam);
        $customerRole = 'sysadmin';
/*        # SYSTEM ADMINISTRATOR ROLES 
        if(isset($adminTeamRole))
        {
            $adminTeamRole = $currentUser->teamRole($adminTeam)->key;
            switch($adminTeamRole)
            {
                case 'owner':
                {
                    $customerRole = 'sysadmin';
                    break;
                }
                case 'admin':
                {
                    $adminTeamMemberActive = DB::table('team_user')->where('user_id', $currentUser->id)->where('team_id', $adminTeam->id)->get()->toArray();
                    if(isset($adminTeamMemberActive[0]) && ($adminTeamMemberActive[0]->active === 1))
                    {
                        $customerRole = 'sysadmin';
                    }
                    break;
                }
            }
        }
        else
        {
            # GROUP MEMBER ROLES
            $currentTeamRole = $currentUser->teamRole($currentUser->currentTeam)->key;
            switch($currentTeamRole)
            {
                case 'owner':
                {
                    $customerRole = 'groupadmin';
                    break;
                }
                case 'admin':
                {
                    $currentTeamMemberActive = DB::table('team_user')->where('user_id', $currentUser->id)->where('team_id', $currentUser->currentTeam->id)->get()->toArray();
                    if(isset($currentTeamMemberActive[0]) && ($currentTeamMemberActive[0]->active !== 1))
                    {
                        $customerRole = 'groupadmin';
                    }
                    break;
                }
            }
        }   # end of else GROUP MEMBER ROLES*/
        if($customerRole === '')
        {
            return redirect('/');         
        }
        else
        {
            app()->instance('customer_role',  $customerRole);
            # read it in controller => $customerRole = resolve('customer_role');
            return $next($request);
        }
    }       # end of handle
}

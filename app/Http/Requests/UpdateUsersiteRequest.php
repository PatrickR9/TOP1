<?php

namespace App\Http\Requests;

//use App\Models\Team;
use App\Http\Controllers\ManagementController;
use App\Models\Usersite;
use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UpdateUsersiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * admin or owner
     */
    public function authorize(Request $req): bool
    {
/*        $currentTeamRole = ManagementController::userTeam();
        $id = $req->post('id');
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $site = Usersite::find($id);
                break;
            }
            case 'groupadmin':
            {
                $site = Usersite::where('team_id', '=', $currentTeamRole->team_id)->find($id);
                break;
            }
            default:
            {
                $site = Usersite::where('user_id', '=', $currentTeamRole->user_id)->where('team_id', '=', $currentTeamRole->team_id)->find($id);
                break;
            }
        }
        return isset($site);*/
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Livewire\DEditor;

use App\Http\Controllers\ManagementController;
use App\Models\Usersite;
use Illuminate\Http\Request;
use Livewire\Component;

class Sites extends Component
{
    public $parentId;
    public $siteId;
    public $siteTitle;
    public $statusValues = ['off', 'on'];
    public $subSiteTitle;
    
    public $siteTree;

    public function mount()
    {
        $this->reload();
    }
    public function newSite($parentId)
    {
        $this->parentId = $parentId;
    }
    public function newSiteCancel()
    {
        unset($this->parentId);
        unset($this->subSiteTitle);
    }
    public function newSiteSave()
    {
        $currentTeamRole = ManagementController::userTeam();
        $currentSite = new Usersite;
        # if user / team site must be created teamID required
        if(false)
        {
            switch($currentTeamRole->role)
            {
                case 'sysadmin':
                case 'groupadmin':
                {
                    $currentSite->type = 0;
                    break;
                }
                default:
                {
                    $currentSite->type = 1;   
                    break;
                }
            }
        }
        $currentSite->user_id = $currentTeamRole->user_id;
        $currentSite->team_id = $currentTeamRole->team_id;
        $currentSite->title = $this->subSiteTitle;
        $currentSite->parentid = $this->parentId;
        $currentSite->url = Usersite::select('url')->find($this->parentId)->url.'/'.urlencode($this->subSiteTitle);
        $currentSite->save();
        $this->newSiteCancel();
        $this->reload();
    }
    private function reload()
    {
        $currentTeamRole = ManagementController::userTeam();
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $this->siteTree = Usersite::getSiteTree();
                break;
            }
            default:
            {
                break;
            }
        }
    }
    public function render(Request $req)
    {
        $viewParams = 
        [
        ];
        return view('livewire.d-editor.sites', $viewParams);
    }
    public function siteSetOffline($siteId)
    {
        $currentSite = Usersite::find($siteId);
        $currentSite->status = 0;
        $currentSite->save();
        $this->reload();
    }
    public function siteSetOnline($siteId)
    {
        $currentSite = Usersite::find($siteId);
        $currentSite->status = 1;
        $currentSite->save();
        $this->reload();
    }
    public function titleCancel()
    {
        unset($this->siteId);
        unset($this->siteTitle);
    }
    public function titleEdit($id)
    {
        $this->siteId = $id;
        $this->siteTitle = Usersite::select('title')->find($id)->title;
    }
    public function titleSave()
    {
        $currentSite = Usersite::find($this->siteId);
        $currentSite->title = $this->siteTitle;
        $currentSite->save();
        $this->titleCancel();
        $this->reload();
    }
}

<?php

namespace App\Livewire;

use App\Http\Controllers\UsersiteController;
use Livewire\Component;

class Managementtopblock extends Component
{
    public $addClass = '';
    public $contentId;
    public $currentSiteName;
    public $currentUserSiteVersions = [];
    protected $listeners = 
    [
        'reRender' => 'reRender'
    ];
    public $step;
    public $selectedFunction = '';
    public $titleId = 2;

    public function apply()
    {
        switch($this->step)
        {
            case 1:
            {
                $this->dispatch('applyStep1', []);
                break;
            }
            case 4:
            {
                $this->dispatch('applyStep4', []);
                break;
            }
            default:
            {
                dump('Methode "apply" unter app\Livewire\Managementtopblock.php anpassen');
                break;
            }
        }
    }
    public function mount()
    {
        $this->reRender();
    }
    public function reloadVersion($versionType, $versionNumber)
    {
        $this->dispatch('startWait', []);
        switch($this->step)
        {
            case 2:
            {
                $this->dispatch('reloadBlockVersion', ['versionType' => $versionType, 'versionNumber' => $versionNumber]);
                break;
            }
            case 3:
            case 4:
            {
                $this->dispatch('reloadMetaVersion', ['versionType' => $versionType, 'versionNumber' => $versionNumber]);
                break;
            }
        }
        $this->skipRender();
    }
/*    public function reloadMetaVersion($versionType, $versionNumber)
    {
        $this->dispatch('reloadMetaVersion', ['versionType' => $versionType, 'versionNumber' => $versionNumber]);
        $this->skipRender();
    }*/
    public function render()
    {
        return view('livewire.managementtopblock');
    }
    public function reRender()
    {
        $this->addClass = '';
        $metaData = [];
        if(isset($this->contentId))
        {
            $metaData = UsersiteController::getUserContentMeta($this->contentId, [$this->titleId], 0); # get meta : title
        }
/*        elseif(isset($this->siteId)) # for future use of creating of standard sites
        {
        } */

        if(isset($metaData[0]) && isset($metaData[0]['value']))
        {
            $this->currentSiteName = $metaData[0]['value'];
        }
        else
        {
            $this->currentSiteName = 'kein Name';
        }
        switch($this->step)
        {
            case 2:
            {
                $this->currentUserSiteVersions = UsersiteController::getUserContentHistory($this->contentId);
                break;
            }
            case 3:
            case 4:
            {
                $this->currentUserSiteVersions = UsersiteController::getUserContentMetaHistory($this->contentId);
                break;
            }
        }
    }
    public function toEdit()
    {
        $this->selectedFunction = '';
    }
    public function toList()
    {
        return redirect()->to('/contents');
    }
    public function toListPrepare()
    {
        $this->selectedFunction = 'toListPrepare';
    }

}

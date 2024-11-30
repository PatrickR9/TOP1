<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsersiteRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Http\Requests\UpdateUsersiteRequest;
use App\Models\Content;
use App\Models\Content2MetaField;
use App\Models\Content2MetaFieldsAutosave;
use App\Models\ContentMetaField;
use App\Models\Siteblock;
use App\Models\SiteblocksAutosave;
use App\Models\Usersite;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class UsersiteController extends Controller
{
    # contributon step 5
    public function contributionCheck($id, Content $content)
    {
        # values of content meta
        $tMetaFieldValues = new Content2MetaField();
        $metaFieldValues = $tMetaFieldValues->where('content_id', '=', $id)->orderBy('sort', 'asc')->get()->toArray();
        # collection of metavalues
        $metaFieldValue = [];
        foreach($metaFieldValues as $metaFieldValueRow)
        {
            $metaFieldValue[$metaFieldValueRow['content_meta_field_id']] = $metaFieldValueRow['value'];
        }
        # contribution attributes
        $tMetaField = new ContentMetaField();
        $metaFields = $tMetaField->select(['id','label', 'contribution_check', 'contribution_warnings'])->get()->toArray();
        $viewParams =
        [
            'contentId' => $id,
            'siteId' => null,
            'siteType' => 'content',
            'step' => 5,
            'stepUrls' => ['step_1' => '/content/'.$id.'/edit', 'step_2' => '/content/'.$id.'/content', 'step_3' => '/content/'.$id.'/materials', 'step_4' => '/content/'.$id.'/properties'],
            'currentContentLabels' => [],
            'currentContentClasses' => [],
            'warningList' => []
        ];
        $currentContent = $content->find($id);
        # add convert content text to structure of metafield and metafield values
        # contribution checks and warnings must add to database !!
        $contentTextToMeta =
        [
            'id' => 'content_text',
            'label' => 'Inhalt',
            'contribution_check' => '{"required":true, "min_length":150, "max_length":350}',
            'contribution_warnings' => '{"required":"Textinhalt fehlt","expected":"die Länge des Inthalttexts muss zwischen 150 und 350 liegen","href":"content/#contentid#/content"}'
        ];
        array_unshift($metaFields, $contentTextToMeta);
        $contentText = '';
        $divider = '';
        foreach($currentContent->siteblocks as $siteBlock)
        {
            $contentText .= $divider.trim(strip_tags($siteBlock['content']));
            $divider = ' ';
        }
        $metaFieldValue['content_text'] = $contentText;
        foreach($metaFields as $metaFieldRow) # $field = metafield ID
        {
            if(isset($metaFieldRow['contribution_check']) && (trim($metaFieldRow['contribution_check']) !== ''))
            {
                $field = $metaFieldRow['id'];
                $criterias = json_decode($metaFieldRow['contribution_check'], true);
                $viewParams['currentContentLabels'][$field] = $metaFieldRow['label'];
                $viewParams['currentContentClasses'][$field] = 'completed';
                $viewParams['warningList'][$field] = json_decode($metaFieldRow['contribution_warnings'], true);
                foreach($criterias as $criteria => $criteraValue)
                {
                    if(isset($metaFieldValue[$field]) && (trim($metaFieldValue[$field]) !== ''))
                    {
                        $fieldValue = $metaFieldValue[$field];
                    }
                    else
                    {
                        $fieldValue = null;
                    }
                    if(isset($criterias['required']) && !isset($fieldValue))
                    {
                        $viewParams['currentContentClasses'][$field] = 'required';
                        break;
                    }
                    elseif(isset($criterias['expected']) && !isset($fieldValue))
                    {
                        $viewParams['currentContentClasses'][$field] = 'expected';
                        break;
                    }
                    else
                    {
                        if($viewParams['currentContentClasses'][$field] === 'completed')
                        {
                            switch($criteria)
                            {
                                case 'max':
                                {
                                    if(!isset($fieldValue) || (intval($fieldValue) > $criteraValue))
                                    {
                                        $viewParams['currentContentClasses'][$field] = 'expected';
                                    }
                                    break;
                                }
                                case 'min':
                                {
                                    if(!isset($fieldValue) || (intval($fieldValue) < $criteraValue))
                                    {
                                        $viewParams['currentContentClasses'][$field] = 'expected';
                                    }
                                    break;
                                }
                                case 'max_length':
                                {
                                    if(!isset($fieldValue) || (mb_strlen($fieldValue) > $criteraValue))
                                    {
                                        $viewParams['currentContentClasses'][$field] = 'expected';
                                    }
                                    break;
                                }
                                case 'min_length':
                                {
                                    if(!isset($fieldValue) || (mb_strlen($fieldValue) < $criteraValue))
                                    {
                                        $viewParams['currentContentClasses'][$field] = 'expected';
                                    }
                                    break;
                                }
                                # max und min length in percent are calculated from content text : $metaFieldValue['content_text']
                                case 'max_length_percent':
                                {
                                    if(!isset($fieldValue) || (mb_strlen($fieldValue) > mb_strlen($metaFieldValue['content_text']) * $criteraValue / 100))
                                    {
                                        $viewParams['currentContentClasses'][$field] = 'expected';
                                    }
                                    break;
                                }
                                case 'min_length_percent':
                                {
                                    if(!isset($fieldValue) || (mb_strlen($fieldValue) < $mb_strlen($metaFieldValue['content_text']) * $criteraValue / 100))
                                    {
                                        $viewParams['currentContentClasses'][$field] = 'expected';
                                    }
                                    break;
                                }
                                # -
                            }
                        }
                    }
                }
            }
        }
        return view('d_editor.index', $viewParams);
    }
    #Show the form for creating a new resource
    public function create()
    {
        return $this->edit(null);
    }
    #Show the form for editing the specified resource
    public function edit($id)
    {
        $viewParams = 
        [
            'siteId' => null,
            'siteType' => 'content',
            'step' => 1,
            'stepUrls' => ['step_1' => '', 'step_2' => '', 'step_3' => '', 'step_4' => '']
        ];
        if(isset($id))
        {
            $viewParams['contentId'] = $id;
        }
        else
        {
            $viewParams['contentId'] = 'new';
        }
        return view('d_editor.index', $viewParams);
    }
    # content edit step 2
    public function editContent($id, Content $content)
    {
        if($content->find($id) === null)
        {
            return redirect('/contents');
        }
        else
        {
    //      $lastActivity = DB::table('sessions')->select('last_activity')->where('id', session()->getId())->first();
            $viewParams = 
            [
                'contentId' => $id,
                'coverLetters' => ['D','i','e','&nbsp;','S','e','i','t','e','&nbsp;','l','ä','d','t'],
                'siteId' => null,
                'siteType' => 'content',
                'step' => 2,
                'stepUrls' => ['step_1' => '/content/'.$id.'/edit', 'step_2' => '', 'step_3' => '', 'step_4' => '']
            ];
            return view('d_editor.index', $viewParams);
        }
    }
    # content edit step 3
    public function editContentMaterials($id, Content $content)
    {
        if ($content->find($id) === null) {
            return redirect('/contents');
        } else {
            $viewParams = [
                'contentId' => $id,
                'siteId' => null,
                'siteType' => 'content',
                'step' => 3,
                'stepUrls' => ['step_1' => '/content/'.$id.'/edit', 'step_2' => '/content/'.$id.'/content', 'step_3' => '', 'step_4' => '']
            ];
        }
        return view('d_editor.index', $viewParams);
    }
    # content edit step 4
    public function editContentProperties($id, Content $content)
    {
        if ($content->find($id) === null) {
            return redirect('/contents');
        } else {
            $viewParams = [
                'contentId' => $id,
                'siteId' => null,
                'siteType' => 'content',
                'step' => 4,
                'stepUrls' => ['step_1' => '/content/'.$id.'/edit', 'step_2' => '/content/'.$id.'/content', 'step_3' => '/content/'.$id.'/materials', 'step_4' => '']
            ];
        }
        return view('d_editor.index', $viewParams);
    }
    public static function getMetaTitleFieldId()
    {
        $metaTitleArray = ContentMetaField::select('id')
            ->where('title_field', '=', 1)
            ->first();
        if(isset($metaTitleArray))
        {
            $metaTitleId = $metaTitleArray->id;
        }
        else
        {
            $metaTitleId = null;
        }
        return $metaTitleId;
    }
    private static function getUserContentAutosaved($id)
    {
        $autosavedVersions = SiteblocksAutosave::select(DB::raw('2 as version_type, autosave_version as version_number, date_format(max(updated_at), "%d.%m.%Y#%H:%i:%s Uhr") as u_date'))->where('content_id', '=', $id)->groupBy('autosave_version')->orderBy('u_date', 'desc')->get()->toArray();
        return $autosavedVersions;
    }
    private static function getUserContentMetaAutosaved($contentId)
    {
        $autosavedVersions = Content2MetaFieldsAutosave::select(DB::raw('2 as version_type, autosave_version as version_number, date_format(max(updated_at), "%d.%m.%Y#%H:%i:%s Uhr") as u_date'))->where('content_id', '=', $contentId)->groupBy('autosave_version')->orderBy('u_date', 'desc')->get()->toArray();
        return $autosavedVersions;
    }
    public static function getUserContent($id)
    {
        $site = null;
        $currentTeamRole = ManagementController::userTeam();
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $site = Content::find($id);
                break;
            }
/*            case 'groupadmin':
            {
                $site = Usersite::where('team_id', '=', $currentTeamRole->team_id)->find($id);
                break;
            }
            default:
            {
                $site = Usersite::where('user_id', '=', $currentTeamRole->user_id)->where('team_id', '=', $currentTeamRole->team_id)->find($id);
                break;
            }*/
        }
        return $site;
    }
    public static function getUserContentHistory($id)
    {
        $history = 
        [
            'vt100' => [],
            'vt0' => [],
            'vt1' => []
        ];
        $currentTeamRole = ManagementController::userTeam();
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $versions = [];
                # get backup and live versions of contents # version_type:  0 = edited, 1 = backup, 2 = autosaved, 100 = published
                $editedVersion = Siteblock::select(DB::raw('version_type, version_number, date_format(updated_at, "%d.%m.%Y#%H:%i:%s Uhr") as u_date'))->where('content_id', '=', $id)->whereNull('deleted_at')->orderBy('version_type', 'asc')->orderBy('updated_at', 'desc')->first();
                if(isset($editedVersion))
                {
                    $versions[] = [$editedVersion->toArray()];
                    unset($editedVersion);
                }
                # get autosaved versions of contents 
                $autosavedVersions = self::getUserContentAutosaved($id);
                if(isset($autosavedVersions) && (count($autosavedVersions) > 0))
                {
                    $versions[] = $autosavedVersions;
                    unset($autosavedVersions);
                }
                $countOfVersions = count($versions);
                for($i = 0; $i < $countOfVersions; $i++)
                {
                    foreach($versions[$i] as $version)
                    {
                        if(is_object($version))
                        {
                            $version = get_object_vars($version);
                        }
                        $versionType = 'vt'.$version['version_type'];
                        $versionNumber = 'vn'.$version['version_number'];
                        if(!isset($history[$versionType]))
                        {
                            $history[$versionType] = [];
                        }
                        if(!isset($history[$versionType][$versionNumber]))
                        {
                            $history[$versionType][$versionNumber] = [];
                        }
                        $uDate = explode('#', $version['u_date']);
                        $history[$versionType][$versionNumber][] = ['date' => $uDate[0], 'time' => $uDate[1]];
                    }
                }
                break;
            }
        }
        $returnHistory = [];
        foreach($history as $index => $historyValues)
        {
            if(count($historyValues) > 0)
            {
                $returnHistory[$index] = $historyValues;
            }
        }
        return $returnHistory;
    }
    public static function getUserContentMetaHistory($contentId)
    {
        $history = 
        [
            'vt100' => [],
            'vt0' => [],
            'vt1' => []
        ];
        $currentTeamRole = ManagementController::userTeam();
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $versions = [];
                # get backup and live versions of contents # version_type:  0 = edited, 1 = backup, 2 = autosaved, 100 = published
                $editedVersion = Content2MetaField::select(DB::raw('version_type, 0 as version_number, date_format(updated_at, "%d.%m.%Y#%H:%i:%s Uhr") as u_date'))->where('content_id', '=', $contentId)->orderBy('version_type', 'asc')->orderBy('updated_at', 'desc')->first();
                if(isset($editedVersion))
                {
                    $versions[] = [$editedVersion->toArray()];
                    unset($editedVersion);
                }
                # get autosaved versions of contents 
                $autosavedVersions = self::getUserContentMetaAutosaved($contentId);
                if(isset($autosavedVersions) && (count($autosavedVersions) > 0))
                {
                    $versions[] = $autosavedVersions;
                    unset($autosavedVersions);
                }
                $countOfVersions = count($versions);
                for($i = 0; $i < $countOfVersions; $i++)
                {
                    foreach($versions[$i] as $version)
                    {
                        if(is_object($version))
                        {
                            $version = get_object_vars($version);
                        }
                        $versionType = 'vt'.$version['version_type'];
                        $versionNumber = 'vn'.$version['version_number'];
                        if(!isset($history[$versionType]))
                        {
                            $history[$versionType] = [];
                        }
                        if(!isset($history[$versionType][$versionNumber]))
                        {
                            $history[$versionType][$versionNumber] = [];
                        }
                        $uDate = explode('#', $version['u_date']);
                        $history[$versionType][$versionNumber][] = ['date' => $uDate[0], 'time' => $uDate[1]];
                    }
                }
                break;
            }
        }
        $returnHistory = [];
        foreach($history as $index => $historyValues)
        {
            if(count($historyValues) > 0)
            {
                $returnHistory[$index] = $historyValues;
            }
        }        
        return $returnHistory;
    }
    #load site meta data
    public static function getUserContentMeta($contentId, $fieldIds = [], $versionType = 0, $versionNumber = null, $display = null)
    {
        $metaDataQuery = Content2MetaField::where('content_id', '=', $contentId)->where('version_type', '=', $versionType);
        if(count($fieldIds) > 0)
        {
            $metaDataQuery->whereIn('content_meta_fields.id', $fieldIds);
        }
        if(isset($versionNumber))
        {
            $metaDataQuery->where('version_number', '=', $versionNumber);
        }
        if(isset($display))    # display: null = all metafields, 0 = hidden fields, > 0 = shown on <display> step
        {
            $metaDataQuery->join('content_meta_fields', function (JoinClause $join) 
            {
                $join->on('content2_meta_fields.content_meta_field_id', '=', 'content_meta_fields.id')
                     ->where('display', '=', $display);
            });
        }
        else
        {
            $metaDataQuery->join('content_meta_fields', 'content2_meta_fields.content_meta_field_id', '=', 'content_meta_fields.id');
        }
        $metaData = $metaDataQuery->orderBy('content_meta_fields.sort', 'asc')->get();
        return $metaData;
    }
    public static function getUserContentMetaArray($contentId, $fieldIds = [], $versionType = 0, $versionNumber = null, $display = null)
    {
        $metaData = self::getUserContentMeta($contentId, $fieldIds, $versionType, $versionNumber, $display);
        if(isset($metaData))
        {
            return $metaData->toArray();
        }
        else
        {
            return [];
        }
    }
    # load site if user has access 
    public static function getUserSite($id)
    {
        $currentTeamRole = ManagementController::userTeam();
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $site = Usersite::find($id);
                break;
            }
/*            case 'groupadmin':
            {
                $site = Usersite::where('team_id', '=', $currentTeamRole->team_id)->find($id);
                break;
            }
            default:
            {
                $site = Usersite::where('user_id', '=', $currentTeamRole->user_id)->where('team_id', '=', $currentTeamRole->team_id)->find($id);
                break;
            }*/
        }
        return $site;
    }
    # show site on frontend
    public function index($site1 = null, $site2 = null, $site3 = null, $site4 = null)
    {
        $sites = [$site1, $site2, $site3, $site4];
        $urlTags = [];
        foreach($sites as $site)
        {
            if(isset($site))
            {
                $urlTags[] = $site;
            }
            else
            {
                break;
            }
        }
        $url = implode('/',$urlTags);
        $userSites = Usersite::where('url','=', $url)->get();
        if(count($userSites) === 0)
        {
//            dump('No sites found');
            return redirect('/');
        }
        else
        {
            $viewParams = 
            [
                'title' => 'Seiten',
                'add_class' => resolve('customer_role')
            ];
            return view('d_editor.sites', $viewParams);
        }
    }
    # lock record of selected block for 1 minutes
    public static function lockSiteBlock($siteBlockId)
    {
        $sessionId = session()->getId();
        $locked = true;
        $siteBlock = Siteblock::find($siteBlockId);
        $currentTimeStamp = date('Y-m-d H:i:s', time());
        $newTimeStamp = date('Y-m-d H:i:s', (time() + 60));
        if($siteBlock->session_id === $sessionId)
        {
            $siteBlock->last_activity = $newTimeStamp;
            $locked = false;
        }
        elseif($siteBlock->last_activity < $currentTimeStamp)
        {
            $siteBlock->last_activity = $newTimeStamp;
            $siteBlock->session_id = $sessionId;
            $locked = false;
        }
        if(!$locked)
        {
            $siteBlock->save();
        }
        return $locked;
    }
    public function settings($id, Content $content)
    {
        if ($content->find($id) === null) {
            return redirect('/contents');
        } else {
            $viewParams = [
                'title' => 'Einstellungen',
                'contentId' => $id,
            ];
        }
        return view('management.content.settings', $viewParams);
    }
    public function showSite($id, Usersite $usersite)
    {
//        $lastActivity = DB::table('sessions')->select('last_activity')->where('id', session()->getId())->first();
        $viewParams = 
        [
            'siteTree' => null,
            'siteId' => $id,
            'contentId' => null,
            'siteType' => 'page',
            'coverLetters' => ['D','i','e','&nbsp;','S','e','i','t','e','&nbsp;','l','ä','d','t']
        ];
        return view('d_editor.index', $viewParams);
    }
    #Store a newly created resource in storage.
    public function store(StoreUsersiteRequest $request)
    {
        //
    }
    # unlock record of selected block
    public static function unlockSiteBlock($siteBlockId)
    {
        $siteBlock = Siteblock::find($siteBlockId);
        $siteBlock->session_id = null;
        $siteBlock->save();
    }
    #Update site properties: label, path etc.
    public function update(UpdateUsersiteRequest $request, Usersite $usersite)
    {
        $currentSite = $usersite::find($request->id);
        $currentSiteUrl = explode('/', $currentSite->url);
        $currentSiteUrlLastIndex = count($currentSiteUrl) - 1;
        $currentSiteUrl[$currentSiteUrlLastIndex] = urlencode(str_replace(' ', '_', $request->title));
        $currentSite->title = $request->title;
        $currentSite->url = implode('/', $currentSiteUrl);
        $currentSite->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usersite $usersite)
    {
        //
    }

}

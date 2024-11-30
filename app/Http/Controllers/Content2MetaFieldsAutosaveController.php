<?php

namespace App\Http\Controllers;

use App\Models\Content2MetaFieldsAutosave;
use App\Models\ContentMetaField;
use App\Models\Content2Metafield;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContent2MetaFieldsAutosaveRequest;
use App\Http\Requests\UpdateContent2MetaFieldsAutosaveRequest;

class Content2MetaFieldsAutosaveController extends Controller
{
    private $maxAutoSave = 3;    # max count of autsaved version of any meta input

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContent2MetaFieldsAutosaveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Content2MetaFieldsAutosave $content2MetaFieldsAutosave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content2MetaFieldsAutosave $content2MetaFieldsAutosave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    ### insert the next lines into LiveWire Component without
    # 
    # use App\Http\Controllers\Content2MetaFieldsAutosaveController;
    #
    ### in attribute definition block
    #
    # public $contentId;    // from Liverwire parameter in resources\views\d_editor\index.blade.php line 21
    # public $metaAutosave;
    # public $updateTimestamp = false;
    #
    # insert this new methode
    /* public function metaUpdateTimer()
    {
        date_default_timezone_set('Europe/Berlin');
        $currentTime = time();
        if(($this->updateTimestamp === false) || ($this->updateTimestamp <= $currentTime))
        {
            $postValues = 
            [
                'contentId' => $this->contentId,
                'mf_<metafield id>' => $this->mf_<metafield id>
                ...

            ];
            $metaAutosave = new Content2MetaFieldsAutosaveController();
            $metaAutosave->update($postValues);
            $this->updateTimestamp = $currentTime + $this->autoSaveTimeStep;
        }
    }*/
    # end of insert into LiveWire component 

    public static function deleteAutosaves($contentId)
    {
        Content2MetaFieldsAutosave::where('content_id', '=', $contentId)
            ->delete();
    }
    public static function getAutoSavedMetaValues($contentId, $autosaveVersion)
    {
        $returnSavedMetaValues = Content2MetaFieldsAutosave::where('content_id', '=', $contentId)
            ->where('autosave_version', '=', $autosaveVersion)
            ->get()
            ->toArray();
/*        foreach($savedVersions as $savedVersion)
        {
            $returnSavedMetaValues[$savedVersion['content_meta_field_id']] = $savedVersion;
        }
        
/*        $lastSavedVersion = Content2MetaFieldsAutosave::select('autosave_version')
            ->where('content_id', '=', $contentId)
            ->orderBy('updated_at', 'desc')
            ->first()
            ->toArray();
        if(isset($lastSavedVersion))
        {
            $autoSavedMetaValues = Content2MetaFieldsAutosave::where('content_id', '=', $contentId)
            ->where('autosave_version', '=', $lastSavedVersion['autosave_version'])
            ->get()
            ->toArray();
            foreach($autoSavedMetaValues as $autoSavedMetaValue)
            {
                $returnSavedMetaValues[$autoSavedMetaValue['content_meta_field_id']] = json_decode($autoSavedMetaValue['value'], true);
            }
        }*/
        return $returnSavedMetaValues;
    }
    public static function getMetaFields($step)
    {
        return ContentMetaField::where('display', '=', $step)
            ->where('active', '=', 1)
            ->orderBy('sort')
            ->get()
            ->toArray();
    }
    public static function getSavedMetaValues($contentId, $metaFieldId = null)
    {
        $content2MetaValueQuery = Content2Metafield::where('content_id', '=', $contentId);
        if(isset($metFieldId))
        {
            $content2MetaValueQuery->where('content_meta_field_id', '=', $metaFieldId);
        }
        $resultArray = $content2MetaValueQuery->get()
            ->toArray();
        $savedMetaValues = [];
        foreach($resultArray as $resultRow)
        {
            $savedMetaValues[$resultRow['content_meta_field_id']] = $resultRow;
        }
        return $savedMetaValues;
    }
    public function update($postValues = []) # values of input fields
    {
        if(isset($postValues['contentId']))
        {
            $autosavedVersions = Content2MetaFieldsAutosave::select('autosave_version')
                ->where('content_id', '=', $postValues['contentId'])
                ->orderBy('updated_at', 'desc')
                ->first();
            if(isset($autosavedVersions))
            {
                $nextAutosaveVersion = ($autosavedVersions->autosave_version + 1) % $this->maxAutoSave;
                Content2MetaFieldsAutosave::where('content_id', '=', $postValues['contentId'])
                    ->where('autosave_version', '=', $nextAutosaveVersion)
                    ->delete();
            }
            else
            {
                $nextAutosaveVersion = 0;
            }
            $contentMetaField = new ContentMetaField();
            $metaFields = $contentMetaField->select(['id', 'sort'])->get()->toArray();
            date_default_timezone_set('Europe/Berlin');
            foreach($metaFields as $metaField)
            {
                $metaFieldId = $metaField['id'];
                if(isset($postValues['mf_'.$metaFieldId]))
                {
                    $content2MetaFieldAutosave = new Content2MetaFieldsAutosave();
                    $content2MetaFieldAutosave->autosave_version = $nextAutosaveVersion;
                    $content2MetaFieldAutosave->content_id = $postValues['contentId'];
                    $content2MetaFieldAutosave->content_meta_field_id = $metaFieldId;
                    $content2MetaFieldAutosave->value = json_encode($postValues['mf_'.$metaFieldId], JSON_UNESCAPED_UNICODE);
                    $content2MetaFieldAutosave->version_type = 0;
                    $content2MetaFieldAutosave->sort = $metaField['sort'];
                    $content2MetaFieldAutosave->updated_at = time();
                    $content2MetaFieldAutosave->save();
                }
            }
        } /* */
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content2MetaFieldsAutosave $content2MetaFieldsAutosave)
    {
        //
    }
}

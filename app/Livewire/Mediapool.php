<?php

namespace App\Livewire;

use App\Http\Classes\Crm;
use App\Http\Controllers\ManagementController;
use App\Models\Mediapool as MediaPoolTable;
use App\Models\MediapoolCategory;
use App\Models\Organisation;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Mediapool extends Component
{
    use WithFileUploads;
    private $fileSizeUnits = 
    [
        'Byte',
        'kB',
        'MB',
        'GB'
    ];
    private $poolViews = 
    [
        'files' => 'Dateien',
        'categories' => 'Kategorien'
    ];
    protected $listeners = 
    [
        'openPool' => 'openPool'
    ];
    public $currentMediumCategoryId = 0;
    public $editCategoryId;
    public $editCategoryName;
    public $editCategoryParentId;
    public $mediumLabelToEdit;
    public $mediumToEdit;
    public $newMedia;
    public $pool;
    public $poolView = 'files';
    public $sources;

    public function addCategory($parentId)
    {
        $this->editCategoryParentId = $parentId;
    }
    public function addMedia($overWrite = false)
    {
        if(isset($this->pool['source']))
        {
            $storagePath = $this->pool['source'];
            Crm::checkStoreDirectory($storagePath);
            if(isset($this->pool['id']))
            {
                $storagePath .= '/'.$this->pool['id'];
                Crm::checkStoreDirectory($storagePath);
            }
            if($overWrite === true)
            {
                foreach($this->newMedia as $uploadedMedia)
                {
                    $originalName = $uploadedMedia->getClientOriginalName();
                    $uploadedMedia->storeAs($storagePath, $mediaFile);
                }
            }
            else
            {
                if(is_array($this->newMedia))
                {
                    $newMedia = $this->newMedia;
                }
                else
                {
                    $newMedia = [$this->newMedia];
                }
                foreach($newMedia as $uploadedMedia)
                {
                    $originalName = $uploadedMedia->getClientOriginalName();
                    $fName = pathinfo($originalName, PATHINFO_FILENAME);
                    $fExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $fNameAddition = '';
                    $fullPath = str_replace('\\', '/', storage_path("app/$storagePath"));
                    $fullFileName = $fullPath.'/'.$fName.$fNameAddition.'.'.$fExtension;
                    $counter = 0;
                    while(file_exists($fullFileName))
                    {
                        $counter++;
                        $fNameAddition = "($counter)";
                        $fullFileName = $fullPath.'/'.$fName.$fNameAddition.'.'.$fExtension;
                    }
                    $fileNameToDb = $fName.$fNameAddition.'.'.$fExtension;
                    $uploadedMedia->storeAs($storagePath, $fileNameToDb);
                    $user = Auth::user();
                    $currentMedium = new MediaPoolTable();
                    $currentMedium->user_id = $user->id;
                    $currentMedium->filename = $fileNameToDb;
                    $currentMedium->mediapool_category_id = $this->currentMediumCategoryId;
                    $currentMedium->save();
                }
            }
        }
        if(isset($storagePath))
        {
            $this->loadPool($storagePath.'/', $this->pool['id']);
        }
        unset($this->newMedia);
    }
    public function cancelCategory()
    {
        unset($this->editCategoryId);
        unset($this->editCategoryName);
        unset($this->editCategoryParentId);
    }
    public function cancelMediumLabel()
    {
        unset($this->editCategoryId);
        unset($this->mediumLabelToEdit);
        unset($this->mediumToEdit);
    }
    public function closePool()
    {
        $this->cancelCategory();
        $this->cancelMediumLabel();
        unset($this->newMedia);
        unset($this->pool);
    }
    public function deleteMedia()
    {
        if(isset($this->pool['source']))
        {
            $storagePath = $this->pool['source'];
            if(isset($this->pool['id']))
            {
                $storagePath .= '/'.$this->pool['id'];
            }
        }
        foreach($this->mediaToDelete as $mediaToDelete => $none)
        {
            Storage::delete($storagePath.'/'.$mediaToDelete);
        }
    } 
    public function deleteMedium($medium)
    {
        if(isset($this->pool['source']))
        {
            $storagePath = $this->pool['source'];
            if(isset($this->pool['id']))
            {
                $storagePath .= '/'.$this->pool['id'];
            }
            switch($this->pool['source'])
            {
                case 'teams':
                {
/*                    $imageInUse = Organisation::where('logo', $medium)->orWhere('logo_for_light_bg', $medium)->orWhere('logo_for_dark_bg', $medium)->count();
                    $this->pool['files'][$medium]['deletable'] = ($imageInUse === 0);
                    if($this->pool['files'][$medium]['deletable'] === true)
                    {
                        $this->mediaToDelete[$medium] = true;
                    }*/
                    break;
                }
            }
        }
    }
    public function editCategory($categoryId)
    {
        $this->editCategoryId = $categoryId;
        $this->editCategoryName = MediapoolCategory::find($categoryId)->name;
    }
    public function editMedium($medium)
    {
        $this->mediumToEdit = $medium;
        $this->editCategoryId = $this->pool['files'][$medium]['category_id'];
        if(isset($this->pool['files'][$medium]['label']))
        {
            $this->mediumLabelToEdit = $this->pool['files'][$medium]['label'];
        }
        else
        {
            $this->mediumLabelToEdit = '';
        }
    }
    public function getCategories()
    {
        $currentTeamRole = ManagementController::userTeam();
        $this->sources = 
        [
            'protected' =>  new \stdClass(),
            'public' =>  new \stdClass()
        ];
        $this->sources['public'] = $this->getCategoryLevelSysAdmin('public');
        switch($currentTeamRole->role)
        {
            case 'sysadmin':
            {
                $this->sources['protected'] = $this->getCategoryLevelSysAdmin('protected');
                break;
            }
            case 'groupadmin':
            {
//                $this->categories = DB::table('mediapool_category')->select('mediapool_category.*');
                break;
            }
            default:
            {
//                $this->categories = DB::table('mediapool_category')->select('mediapool_category.*');
                break;
            }
        }
    }
    private function getCategoryLevelSysAdmin($source, $parentId = null)
    {
        $categories = [];
        $categoryQuery = '';
        $categoryQuery = MediapoolCategory::select('id', 'parent_id', 'organisation_id', 'name');
        # sub category
        if(isset($parentId))
        {
            $categoryQuery->where('parent_id', '=', $parentId);
        }
        # main category
        else
        {
            $categoryQuery->whereNull('parent_id');
        }
        $categoryQuery->where('source', '=', $source);
        $categoryLevel = $categoryQuery->orderBy('name', 'ASC')->get();
        foreach($categoryLevel as $category)
        {
            $tempCategory = new \stdClass();
            $tempCategory->id = $category->id;
            $tempCategory->parent_id = $category->parent_id;
            $tempCategory->organisation_id = $category->organisation_id;
            $tempCategory->name = $category->name;
            if(isset( $category->organisation))
            {
                $tempCategory->organisation_name = $category->organisation->title;
            }
            $tempCategory->categories = $this->getCategoryLevelSysAdmin($source, $category->id);
            $tempCategory->source = $source;
            $tempCategory->countOfFiles = MediaPoolTable::selectRaw('count(id) as countOfFiles')
            ->where('mediapool_category_id', '=', $category->id)->get()[0]->countOfFiles;
            $categories[] = $tempCategory;
        }
        return $categories;
    }
    public function getCategoryOptions($parentId = null, $level = 0)
    {
        $categoryOptions = '';
        $categoryQuery = MediapoolCategory::select('id', 'name')
        ->where('organisation', '=', $this->pool['id']);
        if(isset($parentId))
        {
            $categoryQuery->where('parent_id', '=', $parentId);
        }
        else
        {
            $categoryQuery->whereNull('parent_id');
        }
        $categories = $categoryQuery->orderBy('name')->get();
        $level++;
        foreach($categories as $category)
        {
            $categoryOptions .= 
            '<option class = "option_level_'.$level.'" value = "'.$category->id.'">'.$category->name.'</option>'.$this->getCategoryOptions($category->id, $level);
            
        }
        return $categoryOptions;
    }
/*    private function getOrganisations()
    {
        $organisations = Organisation::select('id', 'title')->orderBy('title', 'asc')->get()->toArray();
        foreach($organisations as &$organisation)
        {
            $organisation['categories'] = $this->getCategoryLevelSysAdmin('protected', $organisation['id']);
        }
        return $organisations;
    }*/
    private function loadPool($storagePath, $categoryId = 0)
    {
        $fileData = [];
        $fileDataToExclude = [];
        $mediaFiles = [];
/*        $publicMediaFiles = $this->pool['id']  === 'root';
//        dump($categoryId, $this->pool['id']);
        if($categoryId === 0)
        {
/*            if(!$publicMediaFiles)
            {
                $categoryIdArray = MediapoolCategory::select('id')->where('organisation_id', '=', $this->pool['id'])->get();
                $categoryIds = [];
                foreach($categoryIdArray as $categoryIdRow)
                {
                    $categoryIds[] = $categoryIdRow->id;
                }
                $mediaFiles = MediapoolTable::select('id', 'user_id', 'filename', 'label', 'uploaded_to')->whereNotIn('mediapool_category_id', $categoryIds)->get();
                foreach($mediaFiles as $mediaFile)
                {
                    $fileDataToExclude[$mediaFile->filename] = 
                    [
                        'id' => $mediaFile->id,
                        'user_id' => $mediaFile->user_id,
                        'label' => $mediaFile->label,
                        'uploaded_to' => $mediaFile->uploaded_to
                    ];
                }
            }
        }
        else
        {
        }*/
        $this->pool['files'] = [];
        if($this->poolView === 'files')
        {
            $mediaFiles = MediapoolTable::select('id', 'user_id', 'filename', 'label', 'uploaded_to')->where('mediapool_category_id', '=', $categoryId)->get();
            foreach($mediaFiles as $mediaFile)
            {
                $fileData[$mediaFile->filename] = 
                [
                    'id' => $mediaFile->id,
                    'user_id' => $mediaFile->user_id,
                    'label' => $mediaFile->label,
                    'uploaded_to' => $mediaFile->uploaded_to
                ];
            }
            $files = Storage::allFiles($storagePath);
            foreach($files as $file)
            {
                $fileName = explode($storagePath, $file)[1];
                if(isset($fileData[$fileName]) || isset($fileDataToExclude[$fileName]))// || $publicMediaFiles)
                {
                    $fullPath = str_replace('\\', '/', storage_path("app/$file"));
                    $mimeType = mime_content_type($fullPath);
                    if(($this->pool['types'] === 'all') || in_array($mimeType, $this->pool['types']))
                    {
                        $fileSize = filesize($fullPath);
                        $unitIndex = 0;
                        while(($unitIndex < 3) && ($fileSize > 1024))
                        {
                            $fileSize = round($fileSize / 1024, 2) ;
                            $unitIndex++;
                        }
                        if(isset($fileData[$fileName]))
                        {
                            $mediaId = $fileData[$fileName]['id'];
                            $label = $fileData[$fileName]['label'];
                            $mediapoolCategoryId = $categoryId;
                            $author = $fileData[$fileName]['user_id'];
                            $uploadedTo = json_decode($fileData[$fileName]['uploaded_to'], true);
                        }
                        else
                        {
                            $mediaId = '';
                            $mediapoolCategoryId = $categoryId;
                            $label = '';
                            $author = '';
                            $uploadedTo = [];
                        }
                        $this->pool['files'][$fileName] = 
                        [
                            'media_id' => $mediaId,
                            'category_id' => $categoryId,
                            'label' => $label,
                            'author' => $author,
                            'uploaded_to' => $uploadedTo,
                            'size' => number_format($fileSize, 2, ',', '').' '.$this->fileSizeUnits[$unitIndex],
                            'mime_type' => $mimeType
                        ];
                    }
                }
            }
            ksort($this->pool['files']);
        }
        #############
/*        $imageId = 3;
        $image = MediapoolTable::find($imageId);
        dump($image->mediapool_category->source);
        dump($image->filename);
        dump($image->mediapool_category_id);
        $storagePath = $image->mediapool_category->source.'/'.$image->mediapool_category_id.'/'.$image->filename;
        dump(Storage::exists($storagePath));
/*
        // Check if the image exists; if not, show placeholder or return a 404 response
        if (Storage::exists($storagePath))
        {
            // Construct the full path to the image within the storage directory
            $path = str_replace('\\', '/', storage_path("app/$storagePath{$imageName}"));
            $returnValue = response()->file($path);
        }
        elseif(Storage::exists("public/media/{$placeholderImage}")) 
        {
            // Construct the full path to the image within the storage directory
            $path = str_replace('\\', '/', storage_path("app/public/media/{$placeholderImage}"));
            $returnValue = response()->file($path);
        }
        else
        {
            abort(404);
        }*/
        // Return the image as a response

    }
    public function mount()
    {
        session()->forget('mediaPoolView');
        $this->mediaToDelete = [];
        if(session()->has('mediaPoolView'))
        {
            $this->poolView = session()->get('mediaPoolView');
        }
        else
        {
            $this->pooView = 'categories';
        }
        $organisations = Organisation::select('id')->get();
        foreach($organisations as $organisation)
        {
            $mediaCategory = MediapoolCategory::select('id')->where('organisation_id', '=', $organisation->id)->whereNull('parent_id')->first();
            if(!isset($mediaCategory))
            {
                $mediaPoolCategory = new MediapoolCategory();
                $mediaPoolCategory->source = 'protected';
                $mediaPoolCategory->name = 'root';
                $mediaPoolCategory->organisation_id = $organisation->id;
                $mediaPoolCategory->save();
            }
        }
        $mediaCategory = MediapoolCategory::select('id')->where('source', '=', 'public')->whereNull('parent_id')->first();
        if(!isset($mediaCategory))
        {
            $mediaPoolCategory = new MediapoolCategory();
            $mediaPoolCategory->source = 'public';
            $mediaPoolCategory->name = 'root';
            $mediaPoolCategory->save();
        }
        $this->skipRender();
    }
    public function openPool($params)
    {
        if(isset($params['dispatch']))
        {
            if($params['id'] === 'root')
            {
                $params['id'] = MediapoolCategory::select('id')->whereNull('parent_id')->where('source', '=', $params['source'])->first()->id;
            }
            $this->pool = 
            [
                'dispatch' => $params['dispatch'],
                'source' => $params['source'],
                'id' => $params['id'],
                'files' => []
            ];
            if(isset($params['target']))
            {
                $this->pool['target'] = $params['target'];
            }
            if(isset($params['types']))
            {
                $this->pool['types'] = $params['types'];
            }
            else
            {
                $this->pool['types'] = 'all';
            }
            $storagePath = $params['source'];
            if(isset($params['id']))
            {
                $storagePath .= '/'.$params['id'].'/';
            }
            $this->loadPool($storagePath, $this->pool['id']);
        }
    }
    public function render()
    {
        $viewParams = 
        [
            'currentView' => $this->poolViews[$this->poolView]
        ];
        if($this->poolView === 'categories')
        {
            $this->getCategories();
        }
        elseif(isset($this->pool))
        {
            if(isset($this->mediumLabelToEdit))
            {
                $viewParams['categoryOptions'] = $this->getCategoryOptions();
            };
            # init first category of organisation
            if($this->currentMediumCategoryId === 0)
            {
                $this->currentMediumCategoryId = $this->pool['id'];
            }
            $viewParams['categoryName'] = MediapoolCategory::select('name')->find($this->currentMediumCategoryId)->name;
            if(trim($viewParams['categoryName']) === '')
            {
                $viewParams['categoryName'] = 'nicht zugeordnet';
            }
            if($this->pool['source'] === 'public')
            {
                $viewParams['organisationName'] = 'Admin';
            }
            else
            {
                $viewParams['organisationName'] = Organisation::select('title')->find($this->pool['id'])->title;
            }
        }
        return view('livewire.mediapool', $viewParams);
    }
    public function saveCategory()
    {
        $parentCategory = MediapoolCategory::find($this->editCategoryParentId);
        if(isset($parentCategory))
        {
            $category = new MediapoolCategory();
            $category->name = $this->editCategoryName;
            $category->parent_id = $this->editCategoryParentId;
            $category->source = $parentCategory->source;
            if(isset($parentCategory->organisation_id))
            {
                $category->organisation_id = $parentCategory->organisation_id;
            }
            $category->save();
        }
        $this->cancelCategory();
    }
    public function saveCategoryById()
    {
        $category = MediapoolCategory::find($this->editCategoryId);
        $category->name = $this->editCategoryName;
        $category->save();
        $this->cancelCategory();
    }
    public function setMedium($mediumId)
    {
        $this->dispatch($this->pool['dispatch'], ['source' => $this->pool['source'], 'sourceId' => $this->currentMediumCategoryId, 'mediumId' => $mediumId, 'targetId' => $this->pool['target'], 'mediumData' => MediaPoolTable::find($mediumId)]);
        $this->closePool();
    }
    public function setView($poolView)
    {
        $this->poolView = $poolView;
        session(['mediaPoolView' => $poolView]);
        $this->cancelCategory();
        $this->cancelMediumLabel();
    }
/*    public function toCategoryFilesByOrganisation($organisationId, $categoryId = 0)
    {
        $this->currentMediumCategoryId = $categoryId;
        $this->poolView = 'files';
        session(['mediaPoolView' => 'files']);
        $this->pool['source'] = 'protected';
        $this->pool['id'] = $categoryId;
        $storagePath = 'protected/'.$organisationId.'/';
        $this->cancelCategory();
        $this->cancelMediumLabel();
        $this->loadPool($storagePath, $categoryId);
    }*/
    public function toCategoryFilesById($categoryId)
    {
/*        $organisationId = MediapoolCategory::find($categoryId)->organisation_id;
        $this->toCategoryFilesByOrganisation($organisationId, $categoryId);*/

        $mediapoolCategory = MediapoolCategory::find($categoryId);
        $this->currentMediumCategoryId = $categoryId;
        $this->poolView = 'files';
        session(['mediaPoolView' => 'files']);
//        $this->pool['source'] = 'protected';
        $this->pool['id'] = $categoryId;
        $storagePath = $mediapoolCategory['source'].'/'.$categoryId.'/';
        $this->cancelCategory();
        $this->cancelMediumLabel();
        $this->loadPool($storagePath, $categoryId);

    }
    public function unDeleteMedium($medium)
    {
        unset($this->pool['files'][$medium]['deletable']);
        unset($this->mediaToDelete[$medium]);
    }
    public function updateMediumLabel($mediumId)
    {
        $this->pool['files'][$this->mediumToEdit]['label'] = $this->mediumLabelToEdit;
        $this->pool['files'][$this->mediumToEdit]['category_id'] = $this->editCategoryId;
        $currentMedium = MediaPoolTable::find($mediumId);
        $currentMedium->label = $this->mediumLabelToEdit;
        $currentMedium->mediapool_category_id = $this->editCategoryId;
        $currentMedium->save();
        $this->toCategoryFilesByOrganisation($this->pool['id'], $this->currentMediumCategoryId);
    }
}

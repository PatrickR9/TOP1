<?php

namespace App\Http\Controllers;

use App\Models\Mediapool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function showImage($imageId)
    {
        $image = Mediapool::find($imageId);
        $storagePath = $image->mediapool_category->source.'/'.$image->mediapool_category_id.'/'.$image->filename;
        // Check if the image exists; if not, show placeholder or return a 404 response
        if(Storage::exists($storagePath))
        {
            // Construct the full path to the image within the storage directory
            $path = str_replace('\\', '/', storage_path("app/$storagePath"));
            $returnValue = response()->file($path);
        }
        else
        {
            abort(404);
        }
        // Return the image as a response
        return $returnValue;
    }
}

<?php
namespace App\Http\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Crm
{
    public static function decode($toDecode, $asArray = false)
    {
        return json_decode(base64_encode($toDecode, $asArray));
    }
    public static function encode($toEncode, $json)
    {
        if($json === true)
        {
            $toEncode = json_encode($toEncode, JSON_UNESCAPED_UNICODE);
        }
        return base64_encode($toEncode);
    }
    public static function checkStoreDirectory($dirName)
    {
        $storeDirectory = str_replace('\\', '/', Storage::path($dirName));
        if(!is_dir($storeDirectory))
        {
            Storage::makeDirectory($dirName);
        }
    }
    public static function createSelectOptions($modelResult, &$value = null)
    {
        $options = [];
        foreach($modelResult as $modelRow)
        {
            $option =[];
            $divider = '';

            foreach($modelRow as $rowField => $rowValue)
            {
                if(isset($option['value']))
                {
                    $option['text'] .= $divider.$rowValue;
                    $divider .= ', ';
                }
                else
                {
                    $option['value'] = $rowValue;
                    $option['text'] = '';
                    if(!isset($value))
                    {
                        $value = $rowValue;
                    }
                }
            }
            if($option['text'] === '')
            {
                $option['text'] = $option['value'];
            }
            $options[] = $option; 
        }
        return $options;
    }
    public static function getEnumFields($tableName)
    {
        $enumOptions = [];
        $enumFields = DB::select("show fields from $tableName where Type like 'enum(%'");
        foreach($enumFields as $enumField)
        {
            $enumOptions[$enumField->Field] = [];
            $enumValues = explode(',', substr($enumField->Type,5, strlen($enumField->Type) - 6));
            foreach($enumValues as $enumValue)
            {
                $enumValue = substr($enumValue, 1, strlen($enumValue) - 2);
                $enumOptions[$enumField->Field][] = [$enumValue, $enumValue];
            }
        }
        return $enumOptions;
    }
    public static function writeMedia($folder, $id, $mediaInputs, $overWrite = false)
    {
        self::checkStoreDirectory($folder);
        $targetDir = $folder.'/'.$id;
        self::checkStoreDirectory($targetDir);
        $mediaFiles = new \stdClass();
        foreach($mediaInputs as $field => $uploadedFile)
        {
            if(isset($uploadedFile) && is_object($uploadedFile))
            {
                $originalName = $uploadedFile->getClientOriginalName();
                /*$hashName = $uploadedFile->hashName();
                $mediaFiles->$field = pathinfo($hashName, PATHINFO_FILENAME).'_'. $originalName;*/
                if($overWrite === true)
                {
                    $mediaFiles->$field = $originalName;
                    $uploadedFile->storeAs($targetDir, $originalName);
                }
                else
                {
                    $fName = pathinfo($originalName, PATHINFO_FILENAME);
                    $fExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $fNameAddition = '';
                    $counter = 0;
                    $fullPath = str_replace('\\', '/', storage_path("app/$targetDir"));
                    if(file_exists($fullPath.'/'.$fName.$fNameAddition.'.'.$fExtension))
                    {
                        $counter++;
                        $fNameAddition = "($counter)";
                    }
                }
            }
            else
            {
                $mediaFiles->$field = $uploadedFile;
            }
        }
        return $mediaFiles;
    }

}
?>
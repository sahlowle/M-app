<?php


namespace App\Traits;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait FileSaveTrait
{
   

    

    /*
     * uploadFile not used
     */
    private function uploadFile($destination, $attribute)
    {
        if (!File::isDirectory(base_path().'/public/files/'.$destination)){
            File::makeDirectory(base_path().'/public/files/'.$destination, 0777, true, true);
        }

        $file_name = time().Str::random(10).'.'.$attribute->extension();
        // $file_name = $attribute->getClientOriginalName();
        $path = 'files/'. $destination .'/' .$file_name;

        try {
            if (env('STORAGE_DRIVER') == 's3' ) {
                $data['is_uploaded'] = Storage::disk('s3')->put($path, file_get_contents($attribute->getRealPath()));
            }else if(env('STORAGE_DRIVER') == 'wasabi' ) {
                $data['is_uploaded'] = Storage::disk('wasabi')->put($path, file_get_contents($attribute->getRealPath()));
            }else if(env('STORAGE_DRIVER') == 'vultr' ) {
                $data['is_uploaded'] = Storage::disk('vultr')->put($path, file_get_contents($attribute->getRealPath()));
            } else {
                $attribute->move(public_path('files/' . $destination .'/'), $file_name);
            }
        } catch (\Exception $e) {
            //
        }

        return $path;
    }

    private function uploadFileWithDetails($destination, $attribute)
    {
        if (!File::isDirectory(base_path().'/public/uploads/'.$destination)){
            File::makeDirectory(base_path().'/public/uploads/'.$destination, 0777, true, true);
        }

        $data['is_uploaded'] = false;

        if ($attribute == null || $attribute == '') {
            return $data;
        }

        $data['original_filename'] = $attribute->getClientOriginalName();
        $file_name = time().Str::random(10).'.'.$attribute->extension();
        $data['path'] = 'uploads/'. $destination .'/' .$file_name;

        try {
            if (env('STORAGE_DRIVER') == 's3' ) {
                $data['is_uploaded'] = Storage::disk('s3')->put($data['path'], file_get_contents($attribute->getRealPath()));
                $data['is_uploaded'] = true;
            }else if(env('STORAGE_DRIVER') == 'wasabi' ) {
                $data['is_uploaded'] = Storage::disk('wasabi')->put($data['path'], file_get_contents($attribute->getRealPath()));
                $data['is_uploaded'] = true;
            }else if(env('STORAGE_DRIVER') == 'vultr' ) {
                $data['is_uploaded'] = Storage::disk('vultr')->put($data['path'], file_get_contents($attribute->getRealPath()));
                $data['is_uploaded'] = true;
            } else {
                $attribute->move(public_path('uploads/' . $destination .'/'), $file_name);
                $data['is_uploaded'] = true;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $data;
    }


    private function deleteFile($path)
    {
        if ($path == null || $path == '') {
            return null;
        }

        try {
            if (env('STORAGE_DRIVER') == 's3') {
                Storage::disk('s3')->delete($path);
            } else {
                File::delete($path);
            }
        } catch (\Exception $e) {
            //
        }

        File::delete($path);
    }

    private function deleteFiles($arrayPath)
    {
        if ($arrayPath == null || $arrayPath == '') {
            return null;
        }

        foreach ($arrayPath as $path ) {
            try {
                if (env('STORAGE_DRIVER') == 's3') {
                    Storage::disk('s3')->delete($path);
                } else {
                    File::delete($path);
                }
            } catch (\Exception $e) {
                //
            }
            File::delete($path);
        }
    }

}
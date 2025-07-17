<?php

namespace App\Helpers;

use File;
use Illuminate\Support\Facades\Storage;

trait UploadFile {

    function storeFile($file, $path)
	{
        if ( ! File::exists(storage_path('app/public/' . $path)) ) {
            File::makeDirectory(storage_path('app/public/' . $path), 0755, true, true);
        }

        $filenameWithExt = $file->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = $file->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = uniqid() . time().'.'.$extension;
        // Upload Image
        $path = $file->storeAs($path, $fileNameToStore, 'public');

        return $fileNameToStore;
    }

    public function deleteFile($file, $path)
    {
        if ( File::exists(storage_path('app/public/'.$path.'/'.$file)) ){
            return File::delete(storage_path('app/public/'.$path.'/'.$file));
        }

        return false;
    }

    public function moveFile ($filename, $path)
    {
        if(is_string($filename)) {
            $from = 'public/' . $path . '/tmp/' . $filename;
            $to = 'public/' . $path . '/' . $filename;

            if(!Storage::exists($from)) return false;
    
            Storage::move($from, $to);
            // Storage::deleteDirectory('public/' . $path . '/tmp');
        }

        foreach((array)$filename as $file) {
            $from = 'public/' . $path . '/tmp/' . $file;
            $to = 'public/' . $path . '/' . $file;

            if (Storage::exists($from)) {
                Storage::move($from, $to);
            }
        }

        Storage::deleteDirectory('public/' . $path . '/tmp');
        return true;
    }
}

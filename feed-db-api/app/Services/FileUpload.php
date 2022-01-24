<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUpload
{
    public function storeFile(UploadedFile $file, string $path)
    {
        $originalName = $file->getClientOriginalName();

        $extension = $file->getClientOriginalExtension();

        $fileName = pathinfo($originalName, PATHINFO_FILENAME);

        $storageName = $fileName."_".uniqid().'.'.$extension;

        $storedName = Storage::putFileAs($path, $file, $storageName);

        return $storedName;
    }

    public function storeFileContentsInChunks(array $contents, $path, $extension, $disk = 'public')
    {

        //print_r($contents);dd();


        $mainPath = $path;

        foreach ($contents as $index => $content) {
            $path = $mainPath.'chunk_'.$index.'.'.$extension;
            Storage::disk($disk)->put($path, $content);
        }
    }
}

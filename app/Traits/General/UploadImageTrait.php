<?php

namespace App\Traits\General;

use Illuminate\Support\Facades\Storage;

trait UploadImageTrait
{
    public function doUpload($storage_name, $request, $path, $file = ''): string|null
    {
        $filename = null;

        if($request->file('file')) {
            $this->deleteImage($storage_name, $path, $file);

            $file = $request->file('file');
            $file->storeAs($path, $file->hashName());

            $filename = $file->hashName();
        }

        return $filename;
    }

    public function deleteImage($storage_name, $path, $file): void
    {
        if(Storage::disk($storage_name)->exists($path . '/' . basename($file))){
            Storage::disk($storage_name)->delete($path . '/' . basename($file));
        }
    }
}

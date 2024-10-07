<?php

namespace App\Traits\General;

use Illuminate\Support\Facades\Storage;

trait UploadImageTrait
{
    public function doUpload($request, $path, $file = ''): string|null
    {
        $filename = null;

        if($request->file('file')) {
            $this->deleteImage($path, $file);

            $file = $request->file('file');
            $file->storeAs($path, $file->hashName());

            $filename = $file->hashName();
        }

        return $filename;
    }

    public function deleteImage($path, $file): void
    {
        if(Storage::disk('local')->exists($path . '/' . basename($file))){
            Storage::disk('local')->delete($path . '/' . basename($file));
        }
    }
}

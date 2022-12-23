<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UploadService
{
    public function uploadImage($imageToUpload, $folder = 'images')
    {
        $path = $imageToUpload->store($folder);

        $image = new Image();

        $image->user_id = Auth::id();
        $image->original_name = $imageToUpload->getClientOriginalName();
        $image->path = $path;
        $image->extension = $imageToUpload->extension();
        $image->size = $imageToUpload->getSize();

        $image->save();

        return $image;

    }
}

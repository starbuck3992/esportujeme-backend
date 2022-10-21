<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageController extends Controller
{
    public function store(ImageStoreRequest $request)
    {
        try {

        $path = $request->image->store('images');

        $image = new Image();

        $image->user_id = Auth::id();
        $image->original_name = $request->image->getClientOriginalName();
        $image->path = $path;
        $image->extension = $request->image->extension();
        $image->size = $request->image->getSize();

        $image->save();

        return response()->json([
            'id' => $image->id,
            'url' => Storage::url($image->path),
            'extension' => $image->extension,
            'size' => $image->size,
        ]);

        } catch (Throwable $e) {

            report($e);

            return response()->json(['message' => 'Nastala chyba při nahrávání obrázku'], 500);

        }

    }
}

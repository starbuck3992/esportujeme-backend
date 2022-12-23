<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageStoreRequest;
use App\Http\Services\UploadService;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function store(ImageStoreRequest $request)
    {
        try {

            $image = $this->uploadService->uploadImage($request->image);

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

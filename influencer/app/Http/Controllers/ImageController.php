<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Str;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request): JsonResponse
    {
        if($file = $request->file('image')){
            $name = Str::random(10);
            $url = $file->storeAs('images', $name . '.' . $file->extension(), 'public');
            $fullUrl = Storage::url($url);

            return response()->json(['url' => $fullUrl], 200);
        }

        return response()->json(['error' => 'Image upload failed.'], 422);
    }
}

<?php

use Illuminate\Support\Facades\Storage;

function upLoadImage($imageInRequest, string $path)
{
    $imageName = time() . '.' . $imageInRequest->getClientOriginalExtension();

    $fullPath = $path . '/' . $imageName;

    Storage::disk('public')->put($fullPath, file_get_contents($imageInRequest));

    return $fullPath;
}

function destroyImage($imageLoaded)
{
    if (!is_null($imageLoaded)) {
        $isThereAnImage = Storage::disk('public')->exists($imageLoaded);

        if ($isThereAnImage) {
            Storage::disk('public')->delete($imageLoaded);
        }
    }
}

function updateImage($imageLoaded, $imageInRequest, string $path)
{
    destroyImage($imageLoaded);
    $image = upLoadImage($imageInRequest, $path);

    return $image;
}

function makeAndDeleteDirectory(string $path)
{
    $fullPath = 'public/' . $path;
    Storage::deleteDirectory($fullPath);
    Storage::makeDirectory($fullPath);
}

function destroyImagesInTests($data)
{
    foreach ($data as $key => $value) {
        destroyImage($value->image);
    }
}

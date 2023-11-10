<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SaveMediaToPublic
{
    protected function saveImage($image, $disk = 'public', $path = '')
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();

        $path = $path ? $path . '/' . $filename : $filename;

        Storage::disk($disk)->putFileAs($path, $image);

        return $path;
    }
}


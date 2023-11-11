<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SaveMedia
{
    protected function saveImage($image, $path = '', $disk = 'public')
    {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        Storage::disk($disk)->putFileAs($path, $image, $filename);

        return "$path/$filename";
    }
}


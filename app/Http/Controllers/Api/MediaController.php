<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Traits\SaveMedia;
use Illuminate\Http\Request;

class MediaController extends BaseController
{
    use SaveMedia;

    public function uploadImage(Request $request)
    {
        try {
            $image = $request->file('image');
            $path = $request->path ?? 'images';
            $resPath = $this->saveImage($image, $path);
            return $this->responseSuccess($resPath);
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}

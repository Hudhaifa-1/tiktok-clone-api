<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileService{
    public function updateImage($model, $request){

        // create new manager instance with desired driver
        $manager = new ImageManager(new Driver());

        // read image from filesystem
        $image = $manager->read($request->file('image'));

        if(!empty($model->image)){
            $currentImage = public_path() . $model->image;

            if(file_exists($currentImage) && $currentImage != public_path() . '/user-placeholder.png'){
                unlink($currentImage);
            }
        }

        $file = $request->file('image');
        $extention = $file->getClientOriginalExtension();

        Log::info('Image object after reading:', [
            'width' => json_encode($request->width),
            'height' => json_encode($request->height),
            'left' => json_encode($request->left),
            'top' => json_encode($request->top)
        ]);

        $image->crop(
            $request->width,
            $request->height,
            $request->left,
            $request->top
        );

        $name = time() . '.' . $extention;
        $image->save(public_path() . '/files/' . $name);
        $model->image = '/files/' . $name;

        return $model;
    }

    public function addVideo($model, $request){
        if (!$request->hasFile('video') || !$request->file('video')->isValid()) {
            // Handle error appropriately
            throw new \Exception('Invalid video upload.');
        }

        $video = $request->file('video');
        $extension = $video->getClientOriginalExtension();
        $name = time() . '.' . $extension;
        $video->move(public_path('files') ,$name);
        $model->video = '/files/' . $name;

        return $model;
    }
}

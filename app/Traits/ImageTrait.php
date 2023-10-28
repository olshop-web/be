<?php

namespace App\Traits;

// use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Image;

Trait ImageTrait
{
    public function upload($file){
        $url = $file->store('images');

        return[
            "filename" => $file->hashName(),
            "path" => "/" . explode("/", $url)[0]. "/",
            "type" => $file->extension(),
            "size" => $file->getSize(),
        ];
        
    }
    public function resize($img){
        $image = getimagesize($img);

        $width = $image[0];
        $height = $image[1];

        $widthOver = $width*2; 
        $heightOver = $height*2;

        $widthHalf = $width/2; 
        $heightHalf = $height/2;

        $resultWidht = 0;
        $resultHeight = 0;

        if ($width == $height) {
            $resultWidht = 300;
            $resultHeight = 300;
        }else if($widthOver <= $height){
            $resultWidht = 150;
            $resultHeight = 300;
        }else if($heightOver <= $width){
            $resultWidht = 300;
            $resultHeight = 150;
        }else if($width < $height){
            $resultWidht = 250;
            $resultHeight = 300;
        }else if($width > $height){
            $resultWidht = 300;
            $resultHeight = 250;
        }
        $path = $this->upload($img);
        $result = Image::make($img->path());
        return $result->resize($resultWidht, $resultHeight, function ($constraint) {
            $constraint->aspectRatio();
        })->save(explode('/',$path['path'])[1].'\\'.$path['filename']);
    }
    public function original($img){
        $store = $img->store('/original');
        $storeExplode = explode('/', $store);

        $save = $img->move('original/', $storeExplode[1]);
        // dd($img->hashName());
        return[
            "filename" => $storeExplode[1],
            "path" => "/original/",
            "full" => "/original/".$storeExplode[1],
        ];
    }
    public function delete($image){
        $explodeImage = explode('/', $image->image);
        $explodeImageOriginal = explode('/', $image->image_original);
        if(Storage::disk('images')->exists($explodeImage[1])){
            Storage::disk('images')->delete($explodeImage[1]);
        }
        if(Storage::disk('images_original')->exists($explodeImageOriginal[1])){
            Storage::disk('images_original')->delete($explodeImageOriginal[1]);
        }
    }
}

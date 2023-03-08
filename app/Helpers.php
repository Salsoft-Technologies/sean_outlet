<?php

use App\Models\Image;
use Illuminate\Support\Facades\Auth;


// upload single image
function uploadImage($image){
    $filename = date("YmdHisu").'.'.$image->extension();
    if($path = $image->storeAs('public/', $filename)){
        return url("storage/{$filename}");
    }
}

// upload more than one images
function uploadManyImages($images){
    $allowedExtensions = ['jpg','png','jpeg'];

    foreach($images as $key => $image){
        $extension = $image->extension();
        $check = in_array($extension, $allowedExtensions);
        // if extension is in allowed extension then proceed.  
        if($check){
            $image_name = 'img_'.date("YmdHisu").$key.'.'.$extension;
            // upload image to server
            if($path = $image->storeAs('public/', $image_name)){                
                //store image file into directory and db
                $save_img = new Image();
                $save_img->user_id = Auth::id();
                $save_img->file_name = $image_name;
                $save_img->file_path = url('storage/'.$image_name);
                $save_img->file_type = $extension;
                $save_img->save();
            }
        } else {
            return false;
        }
    }
    return true;
}

// return response in json format
function apiJsonResponse($success, $message, $http = 200 ,$data = null){
    return response()->json([
        'success'   => $success,
        'message'   => $message,
        'data'      => $data,
    ], $http);
}
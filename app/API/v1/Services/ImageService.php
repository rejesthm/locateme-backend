<?php


namespace App\API\v1\Services;

use DateTime;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    public function uploadImage($request)
    {

        $date = new DateTime();
        $arr = explode(' ', trim(Auth::user()->fullname));

        $file = $request->file('group_image');


        $filename = strtolower($arr[0] . $date->getTimestamp() . '.' . $file->extension());
        $path =  $file->move(public_path("/images"), $filename);
        $photoUrl = url('/images' . $filename);
    }
}

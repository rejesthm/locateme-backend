<?php


namespace App\API\v1\Services;

use App\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function uploadProfilePhoto($data)
    {
        $model = User::query()->find(Auth::user()->id);
        $model->profile_image = $data['profile_image'];

        if (!$model->save()) {
            throw new \Exception("Unable to change profile photo.", 500);
        }
    }
}

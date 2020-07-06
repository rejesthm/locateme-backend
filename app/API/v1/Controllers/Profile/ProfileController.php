<?php


namespace App\API\v1\Controllers\Profile;

use App\API\v1\Services\ProfileService;
use App\API\v1\Services\helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function uploadProfileImage(Request $request)
    {
        $data = [
            'profile_image'    => $request->input('profile_image'),
        ];
        $fileHelper = new UploadFileHelper("profile");
        $url = $fileHelper->uploadFile($request->file('profile_image'), $data['profile_image']);

        DB::beginTransaction();
        try {
            $service = new ProfileService();
            $data['profile_image'] = $url;
            $response = $service->uploadProfilePhoto($data);
            DB::commit();
            return $this->standardResponse('Profile photo was successfully changed.', $response);
        } catch (\Exception $e) {
            DB::rollback();
            File::delete($url);
            return $this->standardResponse($e->getMessage(), $data, $e->getCode(), $e->getTrace());
        }
    }
}

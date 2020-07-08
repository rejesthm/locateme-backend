<?php


namespace App\API\v1\Controllers\Search;

use App\API\v1\Services\helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $search = $request->input('search');
        $result = User::query()
            ->where('fullname', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")->get();
        $data = $result->map(function ($value, $key) {

            $uploadFileHelper = new UploadFileHelper("profile");
            $value->profile_image = $value->profile_image != null ? $uploadFileHelper->getFile($value->profile_image) : null;
            return $value;
        });
        return $this->standardResponse('Login Successfuly', $data);
    }
}


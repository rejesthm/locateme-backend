<?php


namespace App\API\v1\Controllers\Search;

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
        return $this->standardResponse('Login Successfuly', $result);
    }
}

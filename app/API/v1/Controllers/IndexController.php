<?php

/**
 * Created by VSCode.
 * User: Jesther
 * Date: June 13, 2020
 * Time: 8:37 PM
 */

namespace App\API\v1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function getIndex(Request $request)
    {
        $data = [
            "message"   => "Working!",
            "requests"  => $request->headers->all()
        ];

        return $data;
    }
}

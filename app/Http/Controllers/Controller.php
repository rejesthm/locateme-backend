<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function standardResponse($message, $data = [], $code_sts = 200, $traces = [])
    {
        return response()->json(['message' => $message, 'data' => $data, 'traces' => $traces], $code_sts);
    }
}

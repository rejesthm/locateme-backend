<?php


namespace App\API\v1\Controllers\CreateGroup;

use App\API\v1\Services\CreateGroupService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateGroupController extends Controller
{
    public function createGroup(Request $request)
    {
        $data = [
            'id'    => $request->input('id'),
            'group_name'    => $request->input('group_name'),
            'group_destination_name'    => $request->input('group_destination_name'),
            'group_destination_lat'    => $request->input('group_destination_lat'),
            'group_destination_long'    => $request->input('group_destination_long'),
            'creator_id'    => $request->input('creator_id')
        ];
        try {
            $service = new CreateGroupService();
            $response = $service->actionGroup($data);
            return $this->standardResponse('Registered Successfuly', [$response]);
        } catch (\Exception $e) {
            return $this->standardResponse($e->getMessage(), $data, $e->getCode(), $e->getTrace());
        }
    }
}

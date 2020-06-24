<?php


namespace App\API\v1\Controllers\CreateGroup;

use App\API\v1\Services\CreateGroupService;
use App\API\v1\Services\helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CreateGroupController extends Controller
{
    public function createGroup(Request $request)
    {
        $data = [
            'id'    => $request->input('id'),
            'group_name'    => $request->input('group_name'),
            'group_destination_name'    => $request->input('group_destination_name'),
            'destination_lat'    => $request->input('destination_lat'),
            'destination_long'    => $request->input('destination_long'),
            'creator_id'    => $request->input('creator_id')
        ];

        $fileHelper = new UploadFileHelper("groups");
        $data['group_image_url'] = $fileHelper->uploadFile($request->file('group_image'), $data['group_destination_name']);

        try {

            $service = new CreateGroupService();
            $response = $service->actionGroup($data);
            return $this->standardResponse('Group Registered Successfuly', [$response]);
        } catch (\Exception $e) {
            return $this->standardResponse($e->getMessage(), $data, $e->getCode(), $e->getTrace());
        }
    }
}

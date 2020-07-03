<?php


namespace App\API\v1\Controllers\CreateGroup;

use App\API\v1\Services\CreateGroupService;
use App\API\v1\Services\helpers\UploadFileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateGroupController extends Controller
{
    public function createGroup(Request $request)
    {
        $data = [
            'id'    => $request->input('id'),
            'group_name'    => $request->input('group_name'),
            'group_destination_name'    => $request->input('group_destination_name'),
            'destination_lat'    => $request->input('group_destination_lat'),
            'destination_long'    => $request->input('group_destination_long'),
            'creator_id'    => Auth::user()->id,
            'members'   => $request->input('members'),
        ];
        $fileHelper = new UploadFileHelper("groups");
        $url = $fileHelper->uploadFile($request->file('group_image'), $data['group_destination_name']);

        DB::beginTransaction();
        try {
            $service = new CreateGroupService();
            $data['group_image_url'] = $url;
            $response = $service->actionGroup($data);
            DB::commit();
            return $this->standardResponse('Group Registered Successfuly', $response);
        } catch (\Exception $e) {
            DB::rollback();
            File::delete($url);
            return $this->standardResponse($e->getMessage(), $data, $e->getCode(), $e->getTrace());
        }
    }
}

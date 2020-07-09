<?php


namespace App\API\v1\Services;

use App\API\v1\Models\GroupMembers;
use App\API\v1\Models\Groups;
use App\API\v1\Services\helpers\UploadFileHelper;

class CreateGroupService
{

    private $uploadFileHelper;

    function __construct()
    {
        $this->uploadFileHelper = new UploadFileHelper("groups");
    }

    public function actionGroup($data)
    {
        if (!empty($data['id'])) {
            $model = Groups::query()->find($data['id']);
        }
        if (empty($model)) {
            $model = new Groups();
        }

        $model->group_name = $data['group_name'];
        $model->group_destination = $data['group_destination_name'];
        $model->destination_lat = $data['destination_lat'];
        $model->destination_long = $data['destination_long'];
        $model->group_image_url = $data['group_image_url'];
        $model->creator_id = $data['creator_id'];
        $model->date = now();

        if (!$model->save()) {
            throw new \Exception("Unable to save group " . $data['group_name'], 500);
        }
        $this->saveMembers($data['members'], $model->id);

        return $model;
    }

    public function saveMembers($members, $groupId)
    {

        foreach ($members as $member) {
            $membersModel = new GroupMembers();
            $membersModel->group_id = $groupId;
            $membersModel->user_id = $member['user_id'];
            $membersModel->user_position = 'member';
            if (!$membersModel->save()) {
                throw new \Exception("Unable to save " . $member . " from members", 500);
            }
        }
    }

    public function fetchGroup($userId)
    {
        $model = GroupMembers::query()
            ->where('user_id', $userId)
            ->with(['group'])
            ->get();
        return $model->map(function ($value, $key) {
            $value->group->group_image_url = $value->group->group_image_url != null ? $this->uploadFileHelper->getFile($value->group->group_image_url) : null;
            return $value;
        });
    }

    public function getGroupInformation($id)
    {
        $model = Groups::query()
            ->where('id', $id)
            ->with(['groupmembers'])
            ->first();
        $model->group_image_url = $model->group_image_url != null ? $this->uploadFileHelper->getFile($model->group_image_url) : null;

        return $model;
    }
}

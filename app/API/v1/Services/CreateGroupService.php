<?php


namespace App\API\v1\Services;

use App\Groups;

class CreateGroupService
{
    public function actionGroup($data)
    {
        $model = Groups::query()->find($data['id']);
        if (empty($model)) {
            $model = new Groups();
        }

        $model->group_name = $data['group_name'];
        $model->group_destination = $data['group_destination'];
        $model->group_status = 1;
        $model->date = $data['date'];

        if (!$model->save()) {
            throw new \Exception("Unable to save group", 500);
        }
        return $model;
    }
}

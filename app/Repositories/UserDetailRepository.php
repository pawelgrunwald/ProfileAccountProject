<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Post;

use DB;

class UserDetailRepository extends BaseRepository
{
    public function __construct(UserDetail $model)
    {
        $this->model = $model;
    }

    public function getDataUser($user_id)
    {
        $data = $this->model->where('user_id', $user_id)->first();

        if ($data == '') {
            $this->model->create(['user_id' => $user_id]);
            $data = $this->model->where('user_id', $user_id)->first();
        }

        return $data;
    }

    public function updateDetailData($user_id, $data)
    {
        return $this->model->where('user_id', $user_id)->update($data);
    }
}
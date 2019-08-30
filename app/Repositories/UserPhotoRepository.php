<?php

namespace App\Repositories;

use App\Models\UserPhoto;
use App\Models\User;

use DB;

class UserPhotoRepository extends BaseRepository
{
    public function __construct(UserPhoto $model)
    {
        $this->model = $model;
    }

    public function photo($id)
    {
        return $this->model->find($id);
    }

}

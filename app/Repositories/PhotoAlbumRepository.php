<?php

namespace App\Repositories;

use App\Models\PhotoAlbum;
use App\Models\UserPhoto;

use DB;

class PhotoAlbumRepository extends BaseRepository
{
    public function __construct(PhotoAlbum $model)
    {
        $this->model = $model;
    }

    public function photoAlbum($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    public function album($id)
    {
        return $this->model->find($id);
    }
}

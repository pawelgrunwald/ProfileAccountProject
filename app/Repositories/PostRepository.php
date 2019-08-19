<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Post;

use DB;

class PostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function postsActive()
    {
        return $this->model->where('shared', '1')->orderBy('created_at', 'desc')->get();
    }

    public function inactivePostsUser($user_id)
    {
        return $this->model->where('user_id', $user_id)->where('shared', '0')->orderBy('created_at', 'desc')->get();
    }

    public function checkUserOfPost($post_id)
    {
        return $this->model->find($post_id);
    }
}

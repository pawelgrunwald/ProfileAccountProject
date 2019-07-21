<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\Models\User;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'content', 'image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'shared'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

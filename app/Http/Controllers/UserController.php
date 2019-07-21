<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\User;
use App\Models\UserDetail;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserDetailRepository;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function userTable(PostRepository $postRepository, UserDetailRepository $userDetailRepository) {
        if (Auth::user()->type != 0) {
            return redirect()->route('start');
        }
        $inactivePosts = $postRepository->inactivePostsUser(Auth::user()->id);

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);
        
        return view('user.table', ['inactivePosts' => $inactivePosts,
                                    'userData' => $userData]);
    }
}

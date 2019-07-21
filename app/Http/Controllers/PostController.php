<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\User;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;


class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(PostRepository $postRepository) {
        $posts = $postRepository->postsActive();

        return view('home', ['posts' => $posts]);
    }

    public function storePost(Request $request) {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $request->validate([
            'content' => 'required|max:2048'
        ]);

        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->content = $request->input('content');
        $post->shared = $request->get('sharing');
        $post->save();

        return redirect()->action('PostController@index');
    }


    // user settings of posts

    public function setActive() {
        
    }
}

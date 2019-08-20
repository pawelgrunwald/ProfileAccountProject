<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->postsActive();
        
        return view('home', ['posts' => $posts]);
    }

    public function storePost(Request $request)
    {
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

        if ($post->shared == 0) {
            $postShared = 'nieaktywny';
        } else {
            $postShared = 'aktywny';
        }
        return redirect()->action('PostController@index')->with('status', 'Dodano nowy Post jako '.$postShared);
    }
    // settings posts
    public function setActive(PostRepository $postRepository, $post_id)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        } elseif ($postRepository->dataPost($post_id)->user_id != Auth::user()->id) {
            return redirect('/home');
        }
        $postRepository->update($post_id, ['shared' => 1]);
        return redirect('/profile')->with('status', 'Ustawiono Post jako aktywny');
    }

    public function updatePost(PostRepository $postRepository, $post_id)
    {
        $dataPost = $postRepository->dataPost($post_id);
        
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        } elseif ($dataPost->user_id != Auth::user()->id) {
            return redirect('/home');
        }

        return view('post.editData', ['dataPost' => $dataPost]);
    }

    public function storePostData(Request $request, PostRepository $postRepository)
    {
        $dataPost = $postRepository->dataPost($request->input('post_id'));

        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        } elseif ($dataPost->user_id != Auth::user()->id) {
            return redirect('/home');
        }

        $request->validate([
            'content' => 'required|max:2048'
        ]);

        $data = [];
        $content = $request->input('content');
        $shared = $request->get('sharing');

        if ($content != $dataPost->content) {
            Arr::set($data, 'content', $content);
        }
        if ($shared != $dataPost->shared) {
            Arr::set($data, 'shared', $shared);
        }

        if (empty($data)) {
            $message = 'Brak aktualizacji';
        } else {
            $message = 'Post został poprawnie zaktualizowany';
        }

        $postRepository->update($request->input('post_id'), $data);

        return redirect('/home')->with('status', $message);
    }

    public function deletePost(PostRepository $postRepository, $post_id)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        } elseif ($postRepository->dataPost($post_id)->user_id != Auth::user()->id) {
            return redirect('/home');
        }
        $postRepository->delete($post_id);

        return redirect('/home')->with('status', 'Post został usunięty');
    }
}

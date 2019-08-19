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
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $inactivePosts = $postRepository->inactivePostsUser(Auth::user()->id);

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);
        
        return view('user.table', ['inactivePosts' => $inactivePosts,
                                    'userData' => $userData]);
    }

    public function updateData(UserDetailRepository $userDetailRepository) {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }

        switch($_GET['type']) {
            case 'birth':
                $form = ['type' => 'date', 'inputName' => 'birth', 'name' => 'Data urodzenia'];
            break;
            case 'city':
                $form = ['type' => 'text', 'inputName' => 'city', 'name' => 'Miasto'];
            break;
        }

        return view('user.editData', ['form' => $form]);
    }

    public function storeDetailData(Request $request, UserDetailRepository $userDetailRepository) {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $request->validate([
                'birth' => 'date|before:'.date('Y-m-d'),
                'city' => 'max:100'
        ]);

        $data = [];
        if ($request->has('birth')) {
            $data = ['birth' => $request->input('birth')];
        } else if ($request->has('city')) {
            $data = ['city' => $request->input('city')];
        }

        $userDetailRepository->updateDetailData(Auth::user()->id, $data);
        return redirect('/profile')->with('status', 'Dane zostały poprawnie zmienione');
    }
}
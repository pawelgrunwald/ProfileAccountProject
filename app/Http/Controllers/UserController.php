<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserDetailRepository;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userTable(PostRepository $postRepository, UserDetailRepository $userDetailRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $inactivePosts = $postRepository->inactivePostsUser(Auth::user()->id);

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);
        
        return view('user.table', ['inactivePosts' => $inactivePosts,
                                    'userData' => $userData]);
    }

    public function updateData(UserDetailRepository $userDetailRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);

        return view('user.editData', ['userData' => $userData]);
    }

    public function storeDetailData(Request $request, UserDetailRepository $userDetailRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $request->validate([
                'birth' => 'date|before:'.date('Y-m-d'),
                'city' => 'max:100'
        ]);

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);

        $data = [];
        
        if ($request->input('birth') != $userData->birth) {
            Arr::set($data, 'birth', $request->input('birth'));
        }

        if ($request->input('city') != $userData->city) {
            Arr::set($data, 'city', $request->input('city'));
        }

        if (empty($data)) {
            $message = 'Brak zmian w danych użytkownika';
        } else {
            $message = 'Dane zostały poprawnie zmienione';
        }

        $userDetailRepository->updateDetailData(Auth::user()->id, $data);

        return redirect('/profile')->with('status', $message);
    }
}
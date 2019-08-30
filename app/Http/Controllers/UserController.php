<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\PhotoAlbumRepository;

use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userTable(PostRepository $postRepository, UserDetailRepository $userDetailRepository, PhotoAlbumRepository $photoAlbumRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $inactivePosts = $postRepository->inactivePostsUser(Auth::user()->id);

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);

        $messages = [];

        if ($userData->birth == date('Y-m-d')) {
            Arr::set($messages, 'birthMessage', 'Dzisiaj masz urodziny ! <br> Wszystkiego Najlepszego '. Auth::user()->name);
        }

        $photoAlbum = $photoAlbumRepository->photoAlbum(Auth::user()->id);
        
        return view('user.table', ['inactivePosts' => $inactivePosts,
                                    'userData' => $userData,
                                    'messages' => $messages,
                                    'photoAlbum' => $photoAlbum]);
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
                'city' => 'max:100',
                'profileImage' => 'file|image|max:3072'
        ]);

        $userData = $userDetailRepository->getDataUser(Auth::user()->id);

        $data = [];
        
        if ($request->input('birth') != $userData->birth) {
            Arr::set($data, 'birth', $request->input('birth'));
        }

        if ($request->input('city') != $userData->city) {
            Arr::set($data, 'city', $request->input('city'));
        }

        $message = (empty($data)) ? 'Brak zmian w danych użytkownika' : 'Dane zostały poprawnie zmienione';

        $userDetailRepository->updateDetailData(Auth::user()->id, $data);

        return redirect('/profile')->with('status', $message);
    }

    public function updateProfileImage()
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }

        return view('user.editProfileImage');
    }

    public function storeProfileImage(Request $request, UserDetailRepository $userDetailRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $request->validate([
                'profileImage' => 'file|image|mimes:jpg,png,jpeg|max:4096'
        ]);

        $data = [];
        
        if ($request->hasFile('profileImage')) {
            $image = $request->file('profileImage');
            $filename =  strtolower(Auth::user()->surname) . time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('uploads/profileImages/' . $filename);
            $img = Image::make($image)->save($location);

            Arr::set($data, 'image_user', $filename);
        }
        $message = (empty($data)) ? 'Zdjęcie profilowe nie zostało zmienione': 'Zdjęcie profilowe zostało zmienione';
        
        $userData = $userDetailRepository->getDataUser(Auth::user()->id);
        unlink(public_path('uploads/profileImages/'.$userData->image_user));

        $userDetailRepository->updateDetailData(Auth::user()->id, $data);

        return redirect('/profile')->with('status', $message);
    }
}

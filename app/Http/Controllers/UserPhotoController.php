<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Storage;

use App\Models\UserPhoto;
use App\Models\PhotoAlbum;

use App\Repositories\PhotoAlbumRepository;
use App\Repositories\UserPhotoRepository;

use Image;

class UserPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addAlbum()
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        return view('user.addAlbum');
    }

    public function storeAlbum(Request $request)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }

        $request->validate([
            'albumName' => 'required|max:190'
        ]);

        $album = new PhotoAlbum;
        $album->user_id = Auth::user()->id;
        $album->name = $request->input('albumName');
        $album->save();

        return redirect('/profile')->with('status', 'Dodano album o nazwie '.$request->input('albumName'));
    }

    public function deleteAlbum(PhotoAlbumRepository $photoAlbumRepository, UserPhotoRepository $userPhotoRepository, $id)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }
        $photoAlbum = $photoAlbumRepository->album($id);
        if ($photoAlbum->user_id != Auth::user()->id)
        {
            return redirect('/profile');
        }

        $countPhotos = 0;

        foreach($photoAlbum->photos as $photo)
        {
            if (unlink(public_path($photo->path)))
            {
                $countPhotos++;
                $userPhotoRepository->delete($photo->id);
            }
        }

        if(count($photoAlbum->photos) == $countPhotos)
        {
            $photoAlbumRepository->delete($id);
            $message = 'Album '.$photoAlbum->name.' został usunięty';
            if ($countPhotos != 0)
            {
                $message .= ' wraz ze zdjęciami';
            }
        } else {
            $message = 'Błąd podczas usuwania albumu';
        }

        return redirect('/profile')->with('status', $message);
    }

    public function addPhoto(PhotoAlbumRepository $photoAlbumRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }

        $listAlbum = $photoAlbumRepository->photoAlbum(Auth::user()->id);

        return view('user.addPhoto', ['listAlbum' => $listAlbum]);
    }

    public function storePhotos(Request $request, PhotoAlbumRepository $photoAlbumRepository)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        } elseif ($photoAlbumRepository->album($request->get('albumSelect'))->user_id != Auth::user()->id) {
            return redirect('/add-photo');
        }

        $request->validate([
            'images.*' => 'file|image|mimes:jpg,png,jpeg|max:4096',
            'albumSelect' => 'integer'
        ]);

        if ($request->hasFile('images'))
        {
            $images = $request->file('images');
            foreach ($images as $image)
            {
                $path = $image->storeAs('/uploads/albumImages/',strtolower(Auth::user()->surname) . time() . '-' . $image->getClientOriginalName() .  '.' . $image->getClientOriginalExtension());

                $location = public_path($path);
                $img = Image::make($image)->save($location);

                UserPhoto::create([
                    'photo_album_id' => $request->get('albumSelect'),
                    'path' => $path
                ]);
            }

            $message = 'Zdjęcia zostały dodane poprawnie';
            $redirect = '/profile';
        } else {
            $message = 'Nie wybrano żadnego zdjęcia'; 
            $redirect = '/add-photo'; 
        }
        return redirect($redirect)->with('status', $message);
    }

    public function deletePhoto(PhotoAlbumRepository $photoAlbumRepository, UserPhotoRepository $userPhotoRepository, $photo_id)
    {
        if (Auth::user()->type == 1) {
            return redirect()->route('start');
        }

        $photo = $userPhotoRepository->photo($photo_id);

        if ($photoAlbumRepository->album($photo->photo_album_id)->user_id != Auth::user()->id)
        {
            return redirect('/profile');
        }

        if (unlink(public_path($photo->path)))
        {
            $userPhotoRepository->delete($photo_id);
            $message = 'Zdjęcie zostało usunięte';
        } else {
            $message = 'Wystąpił błąd podczas usuwania zdjęcia';
        }

        return redirect('/profile')->with('status', $message);
    }
}

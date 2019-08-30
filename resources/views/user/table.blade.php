@extends('template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('status'))
                <div class="alert alert-success text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="header-profile-section ">
                <div class="img-box" style="background-image: url( {{ asset('uploads/profileImages/'.$userData->image_user ) }} ); float: left">
                </div>
                <a href="{{ action('UserController@updateProfileImage') }}">Zmień zdjęcie</a>
                <h4>{{ Auth::user()->name.' '.Auth::user()->surname }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-2">
            <div class="header-profile-about">
                <div class="card" style="margin-bottom: 40px;">
                    <div class="card-body">
                        <div class="box">
                            <span>Data urodzenia</span>
                            <span style="float: right;">{{ $userData->birth }}</span>
                        </div>
                        <div class="box">
                            <span>Miasto</span>
                            <span style="float: right;">{{ $userData->city }}</span>
                        </div>
                        <a href="{{ action('UserController@updateData') }}" class="card-link">Edytuj</a>
                        <div class="messages">
                            @if (!empty($messages))
                                @foreach ($messages as $message)
                                    <p>{!! $message !!}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#inactivePosts">
                Nieaktywne posty
            </button>
        </div>
    </div>
    @if (!empty($photoAlbum))
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="add-photo" style="margin: 20px 0px;">
                    <a href="{{ action('UserPhotoController@addAlbum') }}" class="btn btn-primary">Dodaj album</a>
                    <a href="{{ action('UserPhotoController@addPhoto') }}" class="btn btn-primary">Dodaj zdjęcie/a</a>
                </div>
                @foreach ($photoAlbum as $album)
                    <div class="card" style="margin-bottom: 40px;">
                        <div class="card-body">
                            <h4 class="card-title">{{ $album->name }}</h4>
                            <a href="{{ action('UserPhotoController@deleteAlbum', ['id' => $album->id]) }}" type="button" class="btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć album ?')">Usuń</a>
                            <div class="imagesAlbum">

                            @foreach ($album->photos as $photo)
                                <div class="image">
                                    <div class="album-img" style="background-image: url( {{ asset($photo->path) }} ); float: left"></div>
                                    <div class="img-delete"><a href="{{ action('UserPhotoController@deletePhoto', ['id' => $photo->id]) }}" onclick="return confirm('Czy na pewno chcesz usunąć zdjęcie ?')">usuń</a></div>
                                </div>
                            @endforeach

                            </div>
                        </div>

                    </div>

                @endforeach
            </div>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="inactivePosts" tabindex="-1" role="dialog" aria-labelledby="inactivePostsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inactivePostsLabel">Nieaktywne posty</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($inactivePosts as $inactivePost)
                        <div class="card" id="{{ $inactivePost->id }}" style="margin-bottom: 10px;">
                            <div class="card-body">
                                <div class="card-n">
                                    <div class="post-menu-more">
                                        <h5 class="post-menu-more-btn" data-id="{{ $inactivePost->id }}">...</h5>
                                    </div>
                                    <div class="post-menu post-{{ $inactivePost->id }}">
                                        <ul>
                                            <li><a href="{{ URL::to('/post/'.$inactivePost->id.'/set-active') }}" class="a-post-menu btn btn-success">Ustaw jako aktywny</a></li>
                                            <li><a href="{{ URL::to('/post/'.$inactivePost->id.'/edit') }}" class="a-post-menu btn btn-warning">Edytuj</a></li>
                                            <li><a href="{{ URL::to('/post/'.$inactivePost->id.'/delete') }}" class="a-post-menu btn btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć Post ?')">Usuń</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h5 class="card-title">
                                    {{ $inactivePost->user->name }} {{ $inactivePost->user->surname }}
                                </h5>
                                <p class="card-text">
                                    {{ $inactivePost->content }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection('content')
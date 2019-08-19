@extends('template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="header-profile-section">
                <h4>{{ Auth::user()->name.' '.Auth::user()->surname }}</h4>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="header-profile-about">
                <div class="card" style="margin-bottom: 40px;">
                    <div class="card-body">
                        <div class="box">
                            <span>Data urodzenia</span>
                            <span style="float: right;">&nbsp;|&nbsp;<a href="{{ action('UserController@updateData', ['type' => 'birth']) }}">Edytuj</a></span>
                            <span style="float: right;">{{ $userData->birth }}</span>
                        </div>
                        <div class="box">
                            <span>Miasto</span>
                            <span style="float: right;">&nbsp;|&nbsp;<a href="{{ action('UserController@updateData', ['type' => 'city']) }}">Edytuj</a></span>
                            <span style="float: right;">{{ $userData->city }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h5>Nieaktywne posty</h5>
            @foreach ($inactivePosts as $inactivePost)
            <div class="card" id="{{ $inactivePost->id }}" style="margin-bottom: 10px;">
                <div class="card-body">
                    <div class="card-n">
                        <div class="post-menu-more">
                            <h5 class="post-menu-more-btn" data-id="{{ $inactivePost->id }}">...</h5>
                        </div>
                        <div class="post-menu post-{{ $inactivePost->id }}">
                            <ul>
                                <li><a href="{{ URL::to('/post/'.$inactivePost->id.'/setActive') }}" class="a-post-menu">Ustaw jako aktywny</a></li>
                                <li><a href="{{ URL::to('/post/'.$inactivePost->id.'/edit') }}" class="a-post-menu">Edytuj</a></li>
                                <li><a href="{{ URL::to('/post/'.$inactivePost->id.'/delete') }}" class="a-post-menu" onclick="return confirm('Czy na pewno chcesz usunąć Post ?')">Usuń</a></li>
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
@endsection('content')
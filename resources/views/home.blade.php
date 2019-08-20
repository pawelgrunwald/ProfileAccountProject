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
    @if (Auth::user()->type == 0)
        <div class="row justify-content-center" style="margin-bottom: 50px;">
            <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif
            <form action="{{ action('PostController@storePost') }}" method="POST" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <h4>{{ Auth::user()->name }}, co słychać ?</h4>
                    <textarea name="content" class="form-control" rows="6" style="resize: none" placeholder="..."></textarea>
                </div>
                <div class="form-group">
                    <label for="share">Udostępnić teraz ?</label>
                    <select name="sharing" class="form-control col-md-2" id="share">
                        <option value="1">Tak</option>
                        <option value="0">Nie</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Dodaj</button>
            </form>
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($posts as $post)
            <div class="card" id="{{ $post->id }}" style="margin-bottom: 10px;">
                <div class="card-body">
                    @if ($post->user->id == Auth::user()->id)
                        <div class="card-n">
                            <div class="post-menu-more">
                                <h5 class="post-menu-more-btn" data-id="{{ $post->id }}">...</h5>
                            </div>
                            <div class="post-menu post-{{ $post->id }}">
                                <ul>
                                    <li><a href="{{ URL::to('/post/'.$post->id.'/edit') }}" class="a-post-menu btn btn-danger">Edytuj</a></li>
                                    <li><a href="{{ URL::to('/post/'.$post->id.'/delete') }}" class="a-post-menu btn btn-warning" onclick="return confirm('Czy na pewno chcesz usunąć Post ?')">Usuń</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if (session('editPost'))
                        <div class="alert alert-success" role="alert">
                            {{ session('editPost') }}
                        </div>
                    @endif
                    <h5 class="card-title">
                    <a href="{{ URL::to('/'.$post->user->id.'/'.$post->user->name.'-'.$post->user->surname) }}">{{ $post->user->name }} {{ $post->user->surname }}</a>
                    </h5>
                    <p class="card-text">
                        {{ $post->content }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

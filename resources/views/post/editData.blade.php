@extends('template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        @if (isset($dataPost))
            <div class="col-md-6">
                <div class="header-profile-about">
                    <div class="card" style="margin-bottom: 40px;">
                        <div class="card-body">
                            <div class="box">
                                <form action="{{ action('PostController@storePostData') }}"  method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="post_id" value="{{ $dataPost->id }}" />
                                    <div class="form-group">
                                        <label for="content">Treść:</label>
                                        <textarea class="form-control" name="content" id="content" rows="3">{{ $dataPost->content }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="share">Udostępnić teraz ?</label>
                                        <select name="sharing" class="form-control col-md-2" id="share">
                                            @if ($dataPost->shared == 1)
                                                <option value="1" selected>Tak</option>
                                                <option value="0">Nie</option>
                                            @else
                                                <option value="1">Tak</option>
                                                <option value="0" selected>Nie</option>
                                            @endif
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Aktualizuj</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection('content')

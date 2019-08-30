@extends('template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if (session('status'))
                <div class="alert alert-danger text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        @if (isset($listAlbum))
            <div class="col-md-6">
                <div class="header-profile-about">
                    <div class="card" style="margin-bottom: 40px;">
                        <div class="card-body">
                            <div class="box">
                                <form action="{{ action('UserPhotoController@storePhotos') }}"  method="POST" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="images">Zdjęcia</label>
                                        <input type="file" name="images[]" id="images" class="form-control-file" multiple="multiple">
                                    </div>
                                    <div class="form-group">
                                        <label for="albumSelect">Wybierz album</label>
                                        <select class="form-control" name="albumSelect" id="albumSelect">
                                            @foreach ($listAlbum as $album)
                                                <option value="{{ $album->id }}">{{ $album->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Dodaj zdjęcie/a</button>
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

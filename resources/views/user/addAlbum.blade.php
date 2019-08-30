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
            <div class="col-md-6">
                <div class="header-profile-about">
                    <div class="card" style="margin-bottom: 40px;">
                        <div class="card-body">
                            <div class="box">
                                <form action="{{ action('UserPhotoController@storeAlbum') }}"  method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="albumName">Nazwa albumu</label>
                                        <input type="text" name="albumName" id="albumName" class="form-control">
                                    </div>           
                                    <button type="submit" class="btn btn-primary">Dodaj album</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection('content')

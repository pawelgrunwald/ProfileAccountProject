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
                                <form action="{{ action('UserController@storeProfileImage') }}"  method="POST" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="profileImage">Zdjęcie profilowe</label>
                                        <input type="file" name="profileImage" id="profileImage" class="form-control-file" >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Aktualizuj</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection('content')

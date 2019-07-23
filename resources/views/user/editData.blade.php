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
        @if (isset($form))
            <div class="col-md-6">
                <div class="header-profile-about">
                    <div class="card" style="margin-bottom: 40px;">
                        <div class="card-body">
                            <div class="box">
                                <form action="{{ action('UserController@storeDetailData') }}"  method="POST" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="{{ $form['inputName'] }}">{{ $form['name'] }}: </label>
                                        <input type="{{ $form['type'] }}" name="{{ $form['inputName'] }}" id="{{ $form['inputName'] }}" style="float: right;">
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
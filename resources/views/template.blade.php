<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/posts.css') }}">

    <title>@yield('title') PostSite</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-text-color navbar-bg-color">
        <a class="navbar-brand" href="{{ URL::to('/') }}">
            PostSite
        </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            
                            @if (Route::current()->getName() != 'register')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Rejestracja</a>
                                </li>
                            @endif
                        @else
                            @if (Auth::user()->type == '0' or Auth::user()->type == '1')
                            <li class="nav-item">
                                <a class="nav-link" href="{{  URL::to('/home') }}">Strona główna</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{  URL::to('profile/') }}">Profil</a>
                            </li>
                            @endif
                              <li class="nav-item dropdown position-text">
                                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                    @if (Auth::user()->type == '1')
                                      ( Admin )
                                    @endif 
                                    <span class="caret"></span>
                                  </a>

                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                      <ul class="dropdown-nav">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{  URL::to('/profile/settings') }}">Ustawienia</a>
                                        </li>
                                      </ul>

                                      <a class="dropdown-item" href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                          Wyloguj
                                      </a>                                   
                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          @csrf
                                      </form>
                                  </div>
                              </li>
                        @endguest
                    </ul>
      </div>
    </nav>


    @yield('content')
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script src="{{ URL::asset('js/posts/more-post-menu.js')  }}" type="text/javascript"></script>

    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href=@yield('css')>
    <title>@yield('tittle')</title>
    <link rel = "icon" href =
        "../images/book.png"
          type = "image/x-icon">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('index') }}">
        <img src="../images/book.png" width="30" height="30" class="d-inline-block align-top" alt="">
        BookStore
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('UserProfilePage') ? 'green' : '' }}" href="{{ route('UserProfilePage', Auth::id()) }}">{{ Auth::user()->name  }}</a>
                </li>
            @else
                <li class="nav-item">
                <a class="nav-link {{ Route::is('RegistrationUserPage') ? 'green' : '' }}" href="{{ route('RegistrationUserPage') }}">Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('LoginUserPage') ? 'green' : '' }}" href="{{ route('LoginUserPage') }}">Login</a>
                </li>
            @endauth
                {{--            <li class="nav-item dropdown">--}}
                {{--                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                {{--                    Books genre--}}
                {{--                </a>--}}
                {{--                <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                {{--                    <a class="dropdown-item" href="#">Detective</a>--}}
                {{--                    <a class="dropdown-item" href="#">Fantasy</a>--}}
                {{--                    <a class="dropdown-item" href="#">Novel</a>--}}
                {{--                    <a class="dropdown-item" href="#">Humor</a>--}}
                {{--                    <a class="dropdown-item" href="#">Scientific</a>--}}
                {{--                    <div class="dropdown-divider"></div>--}}
                {{--                    <a class="dropdown-item" href="#">Random genre</a>--}}
                {{--                </div>--}}
                {{--            </li>--}}
                <li class="nav-item">
                <a class="nav-link {{ Route::is('book.index') ? 'green' : '' }}" href="{{ route('book.index') }}">Books</a>
                </li>
            @auth
                @foreach(Auth::user()->roles as $role)
                    @if($role->name == "seller")
                            <li class="nav-item">
                            <a class="nav-link {{ Route::is('book.create') ? 'green' : '' }}" href="{{ route('book.create') }}">Add Book</a>
                            </li>
                        @endif
                    @endforeach
                @endauth
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('Logout') ? 'green' : '' }}" href="{{ route('Logout') }}">Logout</a>
                </li>
                @endauth
        </ul>
            <form class="form-inline my-2 my-lg-0" action="{{route('book.index')}}" method="get">
                @csrf
                <input class="form-control mr-sm-2" type="search" placeholder="Search book" aria-label="Search" name="search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
    </div>
</nav>

@yield('content')

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{asset('js/admin.js')}}"></script>
</html>

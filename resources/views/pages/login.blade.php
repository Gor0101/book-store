@extends('layouts.main-layout')
@section('css', '/css/registration.css')
@section('tittle', 'Login Page')

@section('content')

    <section class="vh-100">
        <div class="container py-5 h-100 text-center">
            <img src="../images/book.png"
                 alt="Generic placeholder image" class="img-fluid"
                 style="width: 100px; border-radius: 10px;" />
            <div class="row justify-content-center align-items-center h-100 mt-3">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center">
                                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Login</h3>
                            </div>
                            <form action="{{ route('LoginUserSubmit') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <input type="email" id="emailAddress" name="email" placeholder="Email" class="form-control form-control-lg {{ $errors->first('email') ? 'border-danger' : ''}}" value="{{old('email')}}"/>
                                            <label class="form-label" for="emailAddress">{{$errors->first('email')}}</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <input type="password" id="exampleInputPassword1" name="password" placeholder="Password" class="form-control form-control-lg {{ $errors->first('password') ? 'border-danger' : ''}}" />
                                            <label class="form-label" for="exampleInputPassword1">{{$errors->first('password')}}</label>
                                        </div>


                                    </div>

                                </div>


                                <div class="mt-4 pt-2 text-center">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
                                </div>
                                <div class="form-raw pt-5">
                                    <a href="/sign-up/github"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                        </svg></a>
                                </div>
                            </form>
                            <br>
                            <a href="{{ route('RegistrationUserPage') }}">Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection

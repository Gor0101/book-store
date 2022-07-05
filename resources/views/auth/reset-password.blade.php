@extends('layouts.main-layout')
@section('css', '/css/registration.css')
@section('tittle', 'Password Reset')

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
                                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Write your new password</h3>
                            </div>
                            <form action="{{ route('password.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="token" value="{{$token}}">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-4 mb-4 pb-2 ">

                                        <div class="form-outline">
                                            <input type="email" id="emailAddress" name="email" placeholder="Email" class="form-control form-control-lg {{ $errors->first('email') ? 'border-danger' : ''}}" value="{{ $email ?? old('email')}}"/>
                                            <label class="form-label" for="emailAddress">{{$errors->first('email')}}</label>
                                        </div>

                                    </div>

                                    <div class="col-md-4 mb-4 pb-2 ">

                                        <div class="form-outline">
                                            <input type="password" id="password" name="password" placeholder="Password" class="form-control form-control-lg {{ $errors->first('password') ? 'border-danger' : ''}}" />
                                            <label class="form-label" for="password">{{$errors->first('password')}}</label>
                                        </div>

                                    </div>

                                    <div class="col-md-4 mb-4 pb-2 ">

                                        <div class="form-outline">
                                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmation" class="form-control form-control-lg {{ $errors->first('password_confirmation') ? 'border-danger' : ''}}" />
                                            <label class="form-label" for="password_confirmation">{{$errors->first('password_confirmation')}}</label>
                                        </div>

                                    </div>

                                </div>

                                <div class="mt-4 pt-2 text-center">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Reset</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@extends('layouts.main-layout')

@section('css', '/css/dashboard.css')
@section('tittle', 'Admin Panel')


@section('content')

    @foreach($users as $user)

        @foreach($user->roles as $role)

            @if($role->name == "user")

    <div class="container">


        <div class="col-md-12" id="userCard{{$user->id}}">
            <div class="card b-1 hover-shadow mb-20">
                <div class="media card-body">
                    <div class="media-left pr-12">
                        <img class="avatar avatar-xl no-radius" src="{{$user->profile_image}}" alt="...">
                    </div>
                    <div class="media-body">
                        <div class="mb-2">
                            <span class="fs-20 pr-16">{{$user->name}}</span>
                        </div>
                        <small class="fs-16 fw-300 ls-1">{{$user->email}}</small>
                    </div>
                </div>
                <footer class="card-footer flexbox align-items-center bg-dark">
                    <div>
                        <strong>Registered at:</strong>
                        <span>{{$user->created_at}}</span>
                    </div>
                    <div class="card-hover-show d-flex">
                        <button class="btn btn-xs fs-10 btn-bold delete_btn" type="button" data-target="{{$user->id}}"
                                onclick="deleteUser(this)">Delete {{$user->name}}</button>
                    </div>
                </footer>
            </div>

        </div>

    </div>

    </div>

            @endif

        @endforeach

    @endforeach

@endsection

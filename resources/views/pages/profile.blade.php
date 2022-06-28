@extends('layouts.main-layout')

@section('css', '/css/profile.css')
@section('tittle', 'Profile page')

@section('content')
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="d-flex justify-content-center">
                <div class="col-xl-6 col-md-12 text-center">
                    <div class="card user-card-full">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-25">
                                        <img src="{{ asset($user->profile_image) }}" class="img-radius"
                                             alt="User-Profile-Image" style="width: 180px;">
                                    </div>
                                    <h6 class="f-w-600">{{ $user->name }}</h6>
                                    <h6 class="f-w-600">{{ $user->last_name }}</h6>
                                    <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 text-center">Information</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Email</p>
                                            <h6 class="text-muted f-w-400">{{ $user->email }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Role</p>
                                            <h6 class="text-muted f-w-400">You are {{ $user->roles[1]->name }}</h6>
                                        </div>
                                    </div>
                                        @foreach($user->subscriptions as $sub)
                                            @if(is_null($sub->cancel_at_period_end))
                                            <div class="card-block">
                                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 text-center">
                                                    Subscription</h6>
                                                <div class="row">
                                                    <div class="col-sm-12 text-center">
                                                        <a href="/subscribe/refund/{{$sub->id}}"
                                                           style="color: #ff2e62 !important;">Cancel my subscription</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

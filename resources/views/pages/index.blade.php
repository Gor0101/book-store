@extends('layouts.main-layout')

@section('css', '/css/index.css')
@section('tittle', 'BookStore')

@section('content')
{{--    @dd(Auth::user() && $user->subscriptions->isEmpty())--}}
    @if(Auth::user() && Auth::user()->subscriptions->isEmpty())
            <div id="generic_price_table">
                <section>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <!--PRICE HEADING START-->
                                <div class="price-heading clearfix">
                                    <h1>Our plans</h1>
                                </div>
                                <!--//PRICE HEADING END-->
                            </div>
                        </div>
                    </div>
                    <div class="container">

                        <!--BLOCK ROW START-->
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-md-6">

                                    <!--PRICE CONTENT START-->
                                    <div class="generic_content clearfix">

                                        <!--HEAD PRICE DETAIL START-->
                                        <div class="generic_head_price clearfix">

                                            <!--HEAD CONTENT START-->
                                            <div class="generic_head_content clearfix">

                                                <!--HEAD START-->
                                                <div class="head_bg"></div>
                                                <div class="head">
                                                    <span>{{$plan->name}}</span>
                                                </div>
                                                <!--//HEAD END-->

                                            </div>
                                            <!--//HEAD CONTENT END-->

                                            <!--PRICE START-->
                                            <div class="generic_price_tag clearfix">
                                <span class="price">
                                    <span class="sign">$</span>
                                    <span class="currency">{{$plan->price}}</span>
                                    <span class="month">/MON</span>
                                </span>
                                            </div>
                                            <!--//PRICE END-->

                                        </div>
                                        <!--//HEAD PRICE DETAIL END-->

                                        <!--FEATURE LIST START-->
                                        <div class="generic_feature_list">
                                            <ul>
                                                <li><span>{{$plan->limit}}</span> books you can add per month</li>
                                            </ul>
                                        </div>
                                        <!--//FEATURE LIST END-->

                                        <!--BUTTON START-->
                                        <form action="/subscribe/{{$plan->id}}" method="post">
                                            @csrf
                                            <script
                                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                data-key="pk_test_51L8jHaAcc1mBcc9SMT5X8uaKVc82eoSXIzHhCQHjJ64zk4qjwULCvAGjrvzXnc82tk5ECISZ4mAQYeVtaeE3PaKw00D5Vllhze"
                                                data-name="BookStore"
                                                data-description="Subscribe"
                                                data-image="../images/book.png"
                                                data-label="Sign up"
                                                data-email="{{ auth()->check()?auth()->user()->email: null}}"
                                                data-panel-label="Pay Monthly {{$plan->price}} dollars"
                                                data-locale="auto">
                                            </script>
                                        </form>
                                        {{--                                <div class="generic_price_btn clearfix">--}}
                                        {{--                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Sign up</button>--}}
                                        {{--                                </div>--}}
                                        <!--//BUTTON END-->

                                    </div>
                                    <!--//PRICE CONTENT END-->

                                </div>

                            @endforeach
                        </div>
                    </div>
                </section>

            </div>
        @endif

            @if(Auth::user() && Auth::user()->subscriptions->isNotEmpty() || !Auth::user() )

                <div class="header">

                    <!--Content before waves-->
                    <div class="inner-header flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                             class="bi bi-book"
                             viewBox="0 0 16 16">
                            <path
                                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                        </svg>
                        </svg>
                        <h1>BookStore</h1>
                    </div>

                    <!--Waves Container-->
                    <div>
                        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                            <defs>
                                <path id="gentle-wave"
                                      d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
                            </defs>
                            <g class="parallax">
                                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(41, 43, 44,0.7"/>
                                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(41, 43, 44, 0.5)"/>
                                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(41, 43, 44,0.3)"/>
                            </g>
                        </svg>
                    </div>
                    <!--Waves end-->

                </div>
                <!--Header ends-->

                <!--Content starts-->
                <div class="content flex">
                    <p> By Gor </p>
                </div>
                <!--Content ends-->

            @endif
{{--        @endforeach--}}

        @endsection



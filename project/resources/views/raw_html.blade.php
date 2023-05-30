@extends('layouts.master')
@section('content')
    <div class="wrapper">
        <header class="site-header">
            <div class="logo-menuBars">
                <div class="icon-menu"> <i class="fa fa-bars" aria-hidden="true"></i></div>
                <div class="logoText">
                    <img src="assets/webhook_app/img/site-logo.jpg" alt="/">
                    <h4>{{ config('app.name') }}</h4>
                </div>
            </div>
            <div class="notification-bar">
                <p class="">Your current usage is
                    <span class="Polaris-Badge"><b>6</b></span> out of <span class="Polaris-Badge"><b>20000</b></span> webhooks/month.
                    <span class="bar-close-icon">
                    <a href="javascript:void(0)" class="" >&times;</a>
            </span>
                </p>

            </div>
            <div class="user-profile-parent-div">
                <span class="user-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <div class="user-profile">
                    <h5> Hassan Tahir</h5>
                    <p>appscorridor.myshopify.com</p>
                </div>
            </div>
        </header>
        <div class="container-fluid content-section">
            <div class="row">
                <div class="col-2 left-menu-section left-menu-collapes" id="">

                    <ul class="nav flex-column flex-nowrap overflow-hidden ">
                        {{--<span class="menuClose-btn">--}}
                        {{--<a href="javascript:void(0)" class="icon-close" >&times;</a>--}}
                        {{--</span>--}}
                        <li class="nav-item">
                            <a class="nav-link text-truncate" href="#"><i class="fa fa-cog menu-active-class" aria-hidden="true"></i> <span class=" menu-text">Webhooks Setup</span></a>
                        </li>
                        <li class="nav-item activeClass"><a class="nav-link text-truncate" href="#"><i class="fa fa-registered" aria-hidden="true"></i> <span class=" menu-text">Registered Webhooks</span></a></li>
                        <li class="nav-item"><a class="nav-link text-truncate" href="#"><i class="fa fa-history" aria-hidden="true"></i> <span class=" menu-text">Logs</span></a></li>
                        <li class="nav-item dropdown-link0981">
                            <a class="nav-link collapsed text-truncate" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa fa-user" aria-hidden="true"></i> <span class=" menu-text">Account</span></a>

                        </li>
                        <div class="collapse" id="submenu1" aria-expanded="false">
                            <ul class="flex-column nav sub-item-links">
                                <li class="nav-item"><a class="nav-link py-0" href="#"><i class="fa fa-money" aria-hidden="true"></i><span>Plan Subscription</span></a></li>
                                <li class="nav-item"><a class="nav-link py-0" href="#"><i class="fa fa-info-circle" aria-hidden="true"></i><span>Term and Services</span></a></li>

                            </ul>
                        </div>
                        <li class="nav-item dropdown-link0981">
                            <a class="nav-link collapsed text-truncate" href="#submenu2" data-toggle="collapse" data-target="#submenu2"><i class="fa fa-question-circle" aria-hidden="true"></i> <span class=" menu-text">Need Help?</span></a>

                        </li>
                        <div class="collapse" id="submenu2" aria-expanded="false">
                            <ul class="flex-column nav">
                                <li class="nav-item"><a class="nav-link py-0" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i><span>Guids &amp; FAQ</span></a></li>

                            </ul>
                        </div>
                    </ul>


                </div>
                <div class="col pt-4 right-content-section" style="color: #000">
                    <div class="section-main-heading"><h4>Trigger Webhooks</h4></div>
                    <div class="row pt-4">

                        <div class="col">
                            <div class="event-column">
                                <h2>Location</h2>
                                <p>Event Trigger on:</p>
                                <ul class="events-listing">
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                </ul>
                                <div class="connect-btn">

                                    <button><i class="fa fa-check"></i> Connect</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="event-column">
                                <h2>Location</h2>
                                <p>Event Trigger on:</p>
                                <ul class="events-listing">
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                </ul>
                                <div class="connect-btn">

                                    <button><i class="fa fa-check"></i> Connect</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="event-column">
                                <h2>Location</h2>
                                <p>Event Trigger on:</p>
                                <ul class="events-listing">
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                </ul>
                                <div class="connect-btn">

                                    <button><i class="fa fa-check"></i> Connect</button>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="event-column">
                                <h2>Location</h2>
                                <p>Event Trigger on:</p>
                                <ul class="events-listing">
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle-o "></i>
                                        <span>locations-create</span>
                                    </li>
                                </ul>
                                <div class="connect-btn">

                                    <button><i class="fa fa-check"></i> Connect</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<section class="content-section">--}}
        {{--<div class="left-menu-section">--}}
        {{--<ul>--}}
        {{--<li class="active-li"><a class="menu-active-class" href="#"><i class="fa fa-cog menu-active-class" aria-hidden="true"></i>Webhooks Setup</a></li>--}}
        {{--<li><a href="#"><i class="fa fa-registered" aria-hidden="true"></i>Registered Webhooks</a></li>--}}
        {{--<li><a href="#"><i class="fa fa-history" aria-hidden="true"></i>Logs</a></li>--}}
        {{--<li class="dropdown">--}}
        {{--<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-user" aria-hidden="true"></i>Account<b class="caret"></b></a>--}}
        {{--<ul class="dropdown-menu acc-dropdown-links">--}}
        {{--<li><a href="#"><i class="fa fa-money" aria-hidden="true"></i>Plan Subscription</a></li>--}}
        {{--<li><a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i>Term and Services</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="dropdown">--}}
        {{--<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i>Need Help?<b class="caret"></b></a>--}}
        {{--<ul class="dropdown-menu acc-dropdown-links">--}}
        {{--<li><a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i>Guids &amp; FAQ</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        {{--<div class="right-content-section"></div>--}}
        {{--</section>--}}
    </div>
    @include('partials.models_html')
@endsection
{{--model html here--}}


@section('last_scripts')

    <script type="text/javascript">
        var app_url = '{{ env('APP_URL') }}';
        {{--scripts here--}}
        $(document).on('click', '.app-integration-links', function () {
            var channel_id = $(this).data('channel_id');
            var webhook_event_id = $('#webhook_event_id').val();
            var redirect_url = app_url + 'channel_config/' + channel_id + '/' + webhook_event_id;
            window.location.href = redirect_url;
        });
        $(document).on('click', '.remove-banner-div', function () {
            $('.banner_main_div').remove();

        });
        $(document).on('click', '.app-integration-div', function () {
            $('#webhook_event_id').val($(this).data('webhook_event_id'));
            $("#app-integration-modal").modal('show');
        });

        var side_menu = function() {
//            $('.icon-menu').click(function() {
//                $('.left-menu-collapes').css("width","220px");
//                $('.left-menu-section ul li a').css({"font-size": "14px", "text-align": "left"});
//                $('.menu-text').css("display","inline-block");
//                $('.right-content-section').css("margin-left","220px");
//                $('.icon-close').css("display","inline-block");
//                $('.nav-link[data-toggle].collapsed:after').css("display","inline-block")
//                $('.nav-link').removeClass("hidden");
//
//            });
//            $('.icon-close').click(function() {
//
//                $('.left-menu-collapes').css("width","71px");
//                $('.left-menu-section ul li a').css({"font-size": "24px", "text-align": "center"});
//                $('.menu-text').css("display","none");
//                $('.right-content-section').css("margin-left","70px");
//                $('.icon-close').css("display","none");
//                $('.nav-link').addClass("hidden");
//            });
        };

        $(function(){
            $('.icon-menu').on('click', function(){
                if( $('.left-menu-collapes').is(':visible') ) {
                    $('.left-menu-collapes').animate({ 'width': '0px' }, 'slow', function(){
                        $('.left-menu-collapes').hide();
                    });
                    $('.right-content-section').animate({ 'margin-left': '0px' }, 'slow');
                }
                else {
                    $('.left-menu-collapes').show();
                    $('.left-menu-collapes').animate({ 'width': '220px' }, 'slow');
                    $('.right-content-section').animate({ 'margin-left': '220px' }, 'slow');
                }
            });
        });

        $('.bar-close-icon').click(function () {
            $('.notification-bar').css("display","none");
        });
        $(document).ready(function () {
            $('.right-content-section').css("margin-left","220px");
            $('.notification-bar').css("display","inline-flex");
        });
        $(document).ready(side_menu);
    </script>

@endsection


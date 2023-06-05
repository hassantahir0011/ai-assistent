<header class="site-header">
        <div class="logo-menuBars">
            <a href="#" class="icon-menu"> <i class="fal fa-bars"></i></a>
            <div class="logoText">
                <a href="{{ route("dashboard") }}"><img src="{{ asset('cdn/icon.png') }}" alt="/"></a>
                <h4>{{ config('app.name') }}</h4>
            </div>
        </div>
        {{--@if(\Request::route()->getName()=="dashboard")
        <div class="notification-bar">
            <p class="pkg-with-btn">Your current usage is
                <span class="Polaris-Badge"><b>{{ $processed_webhooks }}</b></span> out of <span class="Polaris-Badge"><b>{{ $allowed_webhooks_tasks }}</b></span> webhooks/month.
                @if($shop->current_plan_type!=='elite')
                    <a href="{{ route('plans_listing') }}" class="up-plan-btn">Upgrade Plan</a>
                @endif
                <span class="bar-close-icon">
                        <a href="javascript:void(0)" class="" >&times;</a>
                   </span>
            </p>
        </div>
        @endif--}}
        @php  $shop_data= session('shop');  @endphp
        <nav id="nav">
            <a href="#" class="icon-menu"> <i class="fal fa-close"></i></a>
            <div class="logoText">
                <a href="{{ route("dashboard") }}"><img src="{{ asset('cdn/icon.png') }}" alt="/"></a>
{{--                <h4>{{ config('app.name') }}</h4>--}}
            </div>

            <ul>
                <li>
                    <a class="nav-link text-truncate" href="{{ route('dashboard') }}">
                        <span class=" menu-text">Dashboard</span>
                    </a>
                </li>
{{--                <li>--}}
{{--                    <a class="nav-link text-truncate" href="{{ route('registered_webhooks') }}">--}}
{{--                        <span class=" menu-text">Registered Webhooks</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a class="nav-link text-truncate" href="{{ route('automate') }}">--}}
{{--                        <span class=" menu-text">Automate</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li>
                    <a class="nav-link text-truncate" href="{{ route('products') }}">
                        <span class=" menu-text">Products</span>
                    </a>
                </li>
{{--                <li>--}}
{{--                    <a class="nav-link text-truncate" href="{{ route('notification.index') }}">--}}
{{--                        <span class=" menu-text">Notifications</span>--}}
{{--                        @php--}}
{{--                            $notfications_count = \App\Entities\Notification::where("shop_id", session('shop')['shop_id'])->where('marked_as_read', false)->count();--}}
{{--                        @endphp--}}

{{--                        @if($notfications_count > 0)--}}
{{--                            <span class="notification-counter">{{ $notfications_count }}</span>--}}
{{--                        @endif--}}
{{--                    </a>--}}
{{--                </li>--}}

            <!--            <li>
                <a class="nav-link text-truncate" href="{{ route('products') }}">
                    <span class=" menu-text">Products</span>
                </a>
            </li>
            <li>
                <a class="nav-link collapsed text-truncate" href="javascript:void(0)" data-toggle="collapse" data-target="#submenu1">
                    <span class=" menu-text">Account</span>
                </a>
            </li>
            <div class="collapse" id="submenu1" aria-expanded="false">
                <ul class="flex-column nav sub-item-links">
                    <li class="nav-item"><a class="nav-link py-0" href="{{ route('plans_listing') }}"><i class="fa fa-money menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Plan Subscriptions</span></a></li>
                    <li class="nav-item"><a class="nav-link py-0" href="{{ route('terms_and_conditions') }}"><i class="fa fa-info-circle menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Terms and Services</span></a></li>
                </ul>
            </div>
            <li>
                <a class="nav-link collapsed text-truncate" href="javascript:void(0)" data-toggle="collapse" data-target="#submenu2"><i class="fa fa-question-circle menu-icons" aria-hidden="true"></i> <span class=" menu-text">Need Help?</span></a>

            </li>
           <div class="collapse" id="submenu2" aria-expanded="false">
                <ul class="flex-column nav sub-item-links">
                    <li class="nav-item"><a class="nav-link py-0" href="{{ route('faqs') }}"><i class="fa fa-question-circle menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Guides &amp; FAQs</span></a></li>

                </ul>
            </div>-->
            </ul>
        </nav>
        <div class="user-profile-parent-div">
            <span class="username_character">{{ getInitialWordCharacters($shop_data['shop_owner']??null) }} </span>
            <div class="desktop-scr-signoutBtn">
                <ul>
                    <li><a href="javascript:">{{ $shop_data['myshopify_domain']??"" }}</a></li>
                    <li class="dropdown">
                        <a class="nav-link text-truncate dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"><i class="fa fa-user menu-icons" aria-hidden="true"></i> <span class=" menu-text">Account</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a  href="{{ route('plans_listing') }}"><i class="fa fa-money menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Plan Subscriptions</span></a></li>
                                <li><a  href="{{ route('terms_and_conditions') }}"><i class="fa fa-info-circle menu-icons" aria-hidden="true"></i><span class="dropdown-child-text">Terms and Services</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li  class="dropdown">
                        <a class="nav-link text-truncate dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown">
                            <i class="fa fa-question-circle menu-icons" aria-hidden="true"></i>
                            <span class=" menu-text">Need Help?</span>
                        </a>
                        <div class="dropdown-menu">
                            <ul>
                                <li>
                                    <a href="{{ route('faqs') }}">
                                        <i class="fa fa-question-circle menu-icons" aria-hidden="true"></i>
                                        <span class="dropdown-child-text">Guides & FAQs</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li><a class="" href="{{ route('install',['switch_account'=>1]) }}"><i class="fa fa-exchange" aria-hidden="true"></i>Switch Store</a></li>
                    <li><a class="" href="{{ route('shop.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>Sign Out</a></li>
                </ul>
            </div>
            <div class="user-profile">
                <h5> {{ $shop_data->name??"" }}</h5>
                <p>{{ $shop_data->shopify_domain??"" }}</p>
            </div>
        </div>

        <div class="user-profile-for-mobile" style="display: none;">
            {{--<ul>--}}
            {{--<li><a href="javascript:">{{ $shop_data['myshopify_domain']??"" }}</a></li>--}}
            {{--<li><a class="" href="{{ route('install',['switch_account'=>1]) }}"><i class="fa fa-exchange" aria-hidden="true"></i>Switch Store</a></li>--}}
            {{--<li><a class="" href="{{ route('shop.logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i>Sign Out</a></li>--}}
            {{--</ul>--}}
        </div>

</header>

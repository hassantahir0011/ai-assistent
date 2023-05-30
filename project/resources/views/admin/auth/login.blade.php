
@extends('admin.layouts.auth')

@section('content')

    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 login-container bs-reset">
                {{--<img class="login-logo login-6" src="../assets/pages/img/login/login-invert.png" />--}}
                <div class="login-content">
                    <h1>Login To Admin</h1>

                    <form class="login-form" method="post" action="{{ route('admin.login.post') }}" id="login-form">
                        {{ csrf_field() }}
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span>Enter  email and password. </span>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 input-style {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input class="form-control form-control-solid placeholder-no-fix form-group" type="email"
                                       autocomplete="off" placeholder="Email" name="email"
                                       data-rule-required="true" value="{{ old('email')?old('email'):'' }}"
                                       data-msg-required="Please enter the email">
                                @if ($errors->has('email'))
                                    <span class="help-block help-block-error">
                                                         {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                                    </span>
                                @endif
                            </div>
                            <div class="col-xs-6 input-style {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input class="form-control form-control-solid placeholder-no-fix form-group" type="password"
                                       autocomplete="off" placeholder="Password" name="password"
                                       data-rule-required="true" value=""
                                       data-msg-required="Please enter the password">
                                @if ($errors->has('password'))
                                    <span class="help-block help-block-error">
                                                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                                    </span>
                                @endif </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="rememberme mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" name="remember" value="1" /> Remember me
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-sm-8 text-right">
                                <div class="forgot-password">
                                    <a href="{{ route('admin.password.request') }}" class="forget-password">Forgot Password?</a>
                                </div>
                                <button class="btn blue" type="submit">Sign In</button>
                            </div>
                        </div>
                    </form>

                </div>
                {{--<div class="login-footer">--}}
                    {{--<div class="row bs-reset">--}}
                        {{--<div class="col-xs-5 bs-reset">--}}
                            {{--<ul class="login-social">--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-social-facebook"></i>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-social-twitter"></i>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="javascript:;">--}}
                                        {{--<i class="icon-social-dribbble"></i>--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-7 bs-reset">--}}
                            {{--<div class="login-copyright text-right">--}}
                                {{--<p>Copyright &copy; Keenthemes 2015</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-md-6 bs-reset">
                <div class="login-bg"> </div>
            </div>
        </div>
    </div>
@stop
@section('last_scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            oric_Validation("login-form");
//            $('.login-password').on('focus', function () {
//                $('#password-hint').show();
//            });
//
//            $('.login-password').on('focusOut', function () {
//                $('#password-hint').hide();
//            });

        });
    </script>
@stop
@extends('admin.layouts.auth')

@section('content')

    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 login-container bs-reset">
                {{--<img class="login-logo login-6" src="../assets/pages/img/login/login-invert.png" />--}}
                <div class="login-content">
                    <h1>Reset Password ?</h1>
                    {{--            <!-- BEGIN FORGOT PASSWORD FORM -->--}}

                    <form id="reset-form" class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.reset') }}">
                        {{ csrf_field() }}
                        @if (session('status'))
                            <div class="flash alert alert-{{ session('status') }}">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="on" placeholder="Email"
                                       name="email" value="{{ old('email',$email ?? '') }}"
                                       data-rule-required="true"
                                       data-msg-required="Please enter the email."
                                       data-rule-email="true"
                                       data-msg-email="Please enter the valid email."
                                       style="display: none">
                            </div>
                        </div>
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="row">
                            <div class="col-xs-6 input-style {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="on"
                                       placeholder="Password" name="password" id="password"
                                       data-rule-required="true"
                                       data-msg-required="Please enter the password."
                                       data-rule-minlength="6"

                                       data-msg-minlength="At least 6 charachters are required.">

                                @if ($errors->has('password'))
                                    <span class="help-block help-block-error">
                                                         {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                                    </span>
                                @endif                            </div>

                            <div class="col-xs-6 input-style {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="on"
                                       placeholder="Confirm Password" name="password_confirmation"
                                       data-rule-required="true"
                                       data-msg-required="Please enter the confirm password."
                                       data-rule-equalTo="#password"
                                       data-msg-equalTo="Confirm password should be same as password.">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block help-block-error">
                                                         {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-actions-btn" style="margin-top: 20px;">

                            <button type="button" onclick="window.location='{{ url('backend/login') }}'" class="btn  btn-outline pull-left">Back</button>
                            <button type="submit"  class="btn btn-primary pull-right">Submit</button>

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
    <div class="copyright"> {{ date("Y") }} © {{ config('general.footerSignature') }}</div>
@stop


{{--@section('content')--}}
{{--    <div class="user-login-5">--}}
{{--        <!-- BEGIN LOGO -->--}}
{{--        <div class="logo">--}}
{{--            <a href="index.html">--}}
{{--                <img src="{{ URL::Asset('assets/pages/img/logo.png') }}" alt=""/> </a>--}}
{{--        </div>--}}
{{--        <!-- END LOGO -->--}}
{{--        <!-- BEGIN LOGIN -->--}}
{{--        <div class="content">--}}
{{--            <!-- BEGIN FORGOT PASSWORD FORM -->--}}

{{--            <form id="reset-form" class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.request') }}">--}}
{{--                {{ csrf_field() }}--}}
{{--                @if (session('status'))--}}
{{--                    <div class="flash alert alert-{{ session('status') }}">--}}
{{--                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}

{{--                        {{ session('status') }}--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <input type="hidden" name="token" value="{{ $token }}">--}}
{{--                <h3 class="font-green">Reset Password ?</h3>--}}

{{--                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">--}}
{{--                    <input class="form-control placeholder-no-fix" type="text" autocomplete="on" placeholder="Email"--}}
{{--                           name="email" value="{{ old('email',$email ?? '') }}"--}}
{{--                           data-rule-required="true"--}}
{{--                           data-msg-required="Please enter the email."--}}
{{--                           data-rule-email="true"--}}
{{--                           data-msg-email="Please enter the valid email."--}}
{{--                    style="display: none">--}}


{{--                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}--}}
{{--                </div>--}}
{{--                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">--}}
{{--                    <input class="form-control placeholder-no-fix" type="password" autocomplete="on"--}}
{{--                           placeholder="Password" name="password" id="password"--}}
{{--                           data-rule-required="true"--}}
{{--                           data-msg-required="Please enter the password."--}}
{{--                           data-rule-minlength="6"--}}

{{--                           data-msg-minlength="At least 6 charachters are required.">--}}
{{--                    {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}--}}
{{--                </div>--}}
{{--                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">--}}
{{--                    <input class="form-control placeholder-no-fix" type="password" autocomplete="on"--}}
{{--                           placeholder="Confirm Password" name="password_confirmation"--}}
{{--                           data-rule-required="true"--}}
{{--                           data-msg-required="Please enter the confirm password."--}}
{{--                           data-rule-equalTo="#password"--}}
{{--                           data-msg-equalTo="Confirm password should be same as password.">--}}
{{--                    {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}--}}
{{--                </div>--}}
{{--                <div class="form-actions">--}}
{{--                    <button type="button" onclick="window.location='{{ url('backend/login') }}'"--}}
{{--                            class="btn green btn-outline pull-right">Login--}}
{{--                    </button>--}}
{{--                    <button type="submit" class="btn btn-success uppercase green pull-left">Submit</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--            <!-- END FORGOT PASSWORD FORM -->--}}
{{--        </div>--}}
{{--        <div class="copyright"> {{ date("Y") }} © {{ config('general.footerSignature') }}</div>--}}

{{--        @endsection--}}


@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            oric_Validation("reset-form");
        });
    </script>
@stop

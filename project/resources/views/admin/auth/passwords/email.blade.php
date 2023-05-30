
@extends('admin.layouts.auth')
@section('content')
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 login-container bs-reset">
                {{--<img class="login-logo login-6" src="../assets/pages/img/login/login-invert.png" />--}}
                <div class="login-content">

                    <form id="reset-form" class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.email') }}">
                        {{ csrf_field() }}
                        <h3 class="font-green">Reset Password ?</h3>
                        @if (session('status'))
                            <div class="flash alert alert-success }}">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="email-input-style {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input class="form-control placeholder-no-fix" type="text" autocomplete="on" placeholder="Email"
                                       name="email" value="{{ old('email') }}"
                                       data-rule-required="true"
                                       data-msg-required="Please enter the email."
                                       data-rule-email="true"
                                       data-msg-email="Please enter the valid email."
                                >

                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>

                        <div class="form-actions-btn" style="margin-top: 20px;">

                            <button type="button" onclick="window.location='{{ url('backend/login') }}'" class="btn  btn-outline pull-left">Back</button>
                            <button type="submit"  class="btn btn-primary pull-right">Reset Password</button>

                        </div>

                    </form>

                <!-- END FORGOT PASSWORD FORM -->
                </div>
                <div class="login-footer">
                    <div class="row bs-reset">
                        <div class="col-xs-5 bs-reset">
                            <ul class="login-social">
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <i class="icon-social-dribbble"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-7 bs-reset">
                            <div class="login-copyright text-right">
                                <p>Copyright &copy; Keenthemes 2015</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 bs-reset">
                <div class="login-bg"> </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            oric_Validation("reset-form");
        });
    </script>
@stop


<?php
$asset_controls =
    ['sweetalert', 'validation', 'select2','icheck'];

?>
@extends('insurers.layouts.master')

@section('breadcrumb')
<section class="content-header">
    <h1>
        User Profile
    </h1>
    <ul class="breadcrumb">
        <li><a href=""><img src="{{ URL::asset('assets/images/home.png')}}" alt="Home" /></a><i class="fa fa-minus" aria-hidden="true"></i></li>
        <li> Dashboard <i class="fa fa-minus" aria-hidden="true"></i></li>
        <li> User Profile <i class="fa fa-minus" aria-hidden="true"></i></li>
        <li class="active"> Update</li>
    </ul>
</section>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="main_formula">
                        <div class="tab-title">
                            <div class="caption font-dark">
                                <span class="caption-subject ">Update Photo</span>
                            </div>
                        </div>
                        <div class="tabs-body">
                            <div class="table-scrollable">
                                <div class="mt-comments user_profile_image">
                                    <div class="mt-comment">
                                        <div class="mt-comment-img user_image">
                                            <img src="{{ URL::asset('assets/layouts/layout/img/photo3.jpg')}}"> </div>
                                        <div class="mt-comment-body userprofile">
                                            <div class="mt-comment-info">
                                                <span class="mt-comment-author">Upload Your Image</span>
                                            </div>
                                            <div class="mt-comment-text"> Image should be atleast 300 x 300 px</div>
                                            <div class="mt-comment-details">
                                                <span class="mt-comment-status mt-comment-status-pending" data-toggle="modal" data-target="#updloadUserPhoto">Upload Photo</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane active" id="main_formula">
                        <div class="tab-title">
                            <div class="caption font-dark">
                                <span class="caption-subject ">Basic Information</span>
                            </div>
                        </div>
                        <div class="tabs-body">
                            <div class="table-scrollable">
                            {!! Form::open(['route' => ['admin.profile.update',$insurer->id],'files'=>'true', 'class'=>"dropzone", 'id'=>"dropzone" ,'method' => 'put', 'enctype'=>"multipart/form-data" ])!!}
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            <label for="First name">First name<span class="required">*</span></label>
                                            <input class="form-control" placeholder="First name"
                                            name="first_name" type="text" id="first_name" value="{{ $insurer->first_name }}"
                                            data-rule-required="true" data-msg-required="Please enter the First name.">
                                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            <label for="Last name">Last name<span class="required">*</span></label>
                                            <input class="form-control" placeholder="Last name"
                                            name="last_name" type="text" id="last_name" value="{{ $insurer->last_name }}"
                                            data-rule-required="true" data-msg-required="Please enter the Last name.">
                                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email">Email<span class="required">*</span></label>
                                            <br>
                                            <input class="form-control" placeholder="Email" name="email"
                                            type="email" id="email"  readonly value="{{ $insurer->email }}"
                                            data-rule-required="true" data-msg-required="Please enter Email.">
                                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('cnic') ? ' has-error' : '' }}">
                                            <label for="cnic">CNIC<span class="required">*</span></label>
                                            <input class="form-control mask_cnic" placeholder="CNIC" name="cnic"
                                            type="text" id="cnic" value="{{ old('cnic')?old('cnic'):($insurer->insurerDetails?$insurer->insurerDetails->cnic:'') }}"
                                            data-rule-required="true" data-msg-required="Please enter CNIC.">
                                            {!! $errors->first('cnic', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                            <label for="Phone">Mobile #<span class="required">*</span></label>
                                            <input class="form-control mask_celphone" placeholder="Phone Number"
                                            name="mobile_no" type="text" id="mobile_no" value="{{ $insurer->mobile_no  }}"
                                            data-rule-required="true" data-msg-required="Please enter the Phone Number.">
                                            {!! $errors->first('phone1', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="Password">Password</label>
                                            <input id="password" class="form-control form-control-solid placeholder-no-fix login-password" type="password"
                                            autocomplete="off" placeholder="Password" name="password" data-msg-required="Please enter the password">
                                            @if ($errors->has('password'))
                                                <span class="help-block help-block-error">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                            <label for="Confirm-Password">Confirm Password</label>
                                            <input class="form-control placeholder-no-fix" type="password" autocomplete="on"
                                                    placeholder="Confirm Password" name="confirm_password"
                                                    {{--data-rule-required="true"--}}
                                                    data-msg-required="Please enter the confirm password."
                                                    data-rule-equalTo="#password"
                                                    data-msg-equalTo="Confirm password should be same as password.">
                                            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-flat">Update</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <!-- The Modal -->
    <div class="modal" id="updloadUserPhoto">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <span class="caption-subject"> Upload Image</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <div class="row">
                                        <div class="box-footer">
                                            <button type="button" class="btn btn-primary btn-flat">Upload</button>
                                            <button type="button" class="btn btn-primary btn-flat" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('last_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            oric_Validation_application("dropzone");
            $('#referred_by').select2({
                ajax: {
                    url: "{{ route('company_employees_json') }}",
                    minimumInputLength: 3,
                    data: function (params) {
                        var query = {
                            search: params.term,
                            page: params.page || 1
                        }
                        // Query parameters will be ?search=[term]&page=[page]
                        return query;
                    }
                }
            });
        });

        Dropzone.options.dropzone =
            {
                maxFilesize: 1,
                renameFile: function (file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                timeout: 5000,
                success: function (file, response) {
                    console.log(response);
                },
                error: function (file, response) {
                    return false;
                }
            }
    </script>
@stop
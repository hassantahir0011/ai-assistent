@extends('admin.layouts.master')
<?php
$asset_controls =
    [ 'validation', 'select2'];

?>
<style>
    .breadcrumb {
        margin: 0 !important;
    }

    .my-style {
        background: #fff;
        border-top: 2px solid #30aad9;
        padding: 0 !important;
    }

    .wraper {
        background: #fff;
        padding: 10px;
    }

    .top-head h4 {
        margin: 0;
        padding: 10px 10px;
        border-bottom: 1px solid #ccc;
    }

    .content-div .row {
        margin: 0;
    }

    .lable-style {
        text-align: right;
        line-height: 2.4;
        margin: 0;
        font-weight: bold;
        padding-right: 40px !important;
    }

    .appendable-btns {
        display: flex;
        justify-content: space-between;
    }

    .parent-div {
        display: flex;
    }

    .add_button {
        margin-left: 10px;
    }

    .parent-div-append {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 25px;
    }

    .parent-div-append input {
        width: 100%;
        max-width: 766px;
        margin-right: 11px;

    }

    .parent-div-append a {
        margin: 0 14px 0 0px;
    }

    .tag-input-style .bootstrap-tagsinput {
        display: block;
    }

    .sub-btn {
        text-align: center;
    }

    /*Tags css */


</style>
@section('breadcrumb')
    <section class="content-header">
        <h1>
            Settings
        </h1>

    </section>
@stop
@section('content')
    {{--write code here--}}
    <div class="container-fluid my-style">
        {!! Form::open(['route'=> 'admin.docs.settings.save','method'=>'post','id'=>'form-settings']) !!}
        {{ csrf_field() }}
        <div class="wraper">
            <div class="content-div">
                <div class="form-group row">
                    <label for="status_id"
                           class="col-sm-2 col-form-label col-form-label-sm lable-style">Use Production Docs</label>
                    <div class="col-sm-10">
                        <select id="use_production_docs" name="use_production_docs"
                                data-rule-required="true"
                                class="form-control form-control-sm">
                            <option {{ $settings && $settings->use_production_docs==1?"selected":"" }} value="1">Yes
                            </option>
                            <option {{ $settings && $settings->use_production_docs==0?"selected":"" }} value="0">No
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="thumbnal_link_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">
                        Production Url</label>
                    <div class="col-sm-10">
                        <input type="url" name="production_url" class="form-control form-control-sm input-style"
                               id="production_url"
                               data-rule-required="true"
                               value="{{ $settings && $settings->production_url?$settings->production_url:"" }}"
                               placeholder="server url here..">
                    </div>
                </div>

                <div class="sub-btn">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
@section('last_scripts')
    <script>
//        oric_Validation_application("form-settings");
    </script>
@stop

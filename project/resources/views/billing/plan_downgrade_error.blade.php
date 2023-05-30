@extends('layouts.master')
<style>
    .error-template {padding: 40px 15px;text-align: center;}
    .error-actions {margin-top:15px;margin-bottom:15px;}
    .error-actions .btn { margin-right:10px; }
    .btn{color: #fff!important;}
</style>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Uh Oh!</h1>
                    <h3>
                        Active number of <b>Webhooks or Channels</b> limit reached!</h3>
                    <div class="error-details">
                         {!! $message??'' !!}
                    </div>
                    <div class="error-actions">
                        <a href="{{ route('registered_webhooks') }}" class="btn btn-warning btn-md">Remove webhooks </a>
                            <a href="{{ route('plans_listing') }}" class="btn btn-primary btn-md">
                               Upgrade Plan </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

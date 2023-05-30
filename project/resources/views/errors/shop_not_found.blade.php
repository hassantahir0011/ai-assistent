@extends('layouts.master')
<style>
    .error-template {padding: 40px 15px;text-align: center;}
    .error-actions {margin-top:15px;margin-bottom:15px;}
    .error-actions .btn { margin-right:10px; }
    .btn-primary{color: #fff!important;}
</style>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oops!</h1>
                    <h2>
                        {{ $notice ??'Your sesssion has been expired' }}</h2>

                    <div class="error-details">
                        {{ $message ??'Please restart the app from app sections in shopify admin panel' }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


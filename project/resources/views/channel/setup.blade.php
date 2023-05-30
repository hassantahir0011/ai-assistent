@extends('layouts.master')

<?php

$asset_controls = ['validation', 'rich_textarea', 'querybuilder', 'select2', 'datepicker','lightGallery' ];?>
@section('content')

    @if (isset($_GET['channel_account_id']) && !empty($_GET['channel_account_id']))
        @include('channel.partials.settings')
    @else
        @include('channel.partials.channel_accounts')
    @endif
@endsection


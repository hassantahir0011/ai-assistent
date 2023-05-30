<!DOCTYPE html>
<html lang="en">
<head >
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('cdn/icon-16x16.jpg') }}" type="image/png" sizes="16x16">
    <link href="https://sdks.shopifycdn.com/polaris/3.5.0/polaris.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/webhook_app/css/polaris-webhook.css?v=2') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css', null, true) }}" rel="stylesheet" type="text/css" />


    @if(isset($asset_controls) && !empty($asset_controls))

        <?php foreach(array_unique($asset_controls) as $asset):

        if(!empty($components = get_asset_components($asset,'css'))){
        foreach($components as $component):
        ?>
        <link href="{{ URL::asset($component, null, true) }}" rel="stylesheet" type="text/css" />

        <?php  endforeach;
        }else{
        if(!empty($asset) && strpos('.css',$asset)){
        ?>
        <link href="{{ URL::asset($asset, null, true) }}" rel="stylesheet" type="text/css" />
        <?php
        }   }
        endforeach;
        ?>
    @endif



    @if(isset($asset_controls) && !empty($asset_controls))
        <?php
        foreach(array_unique($asset_controls) as $asset):
        if(!empty($components = get_asset_components($asset, 'js'))){
        if(isset($components['header-js']) && !empty($components['header-js'])){
        foreach($components['header-js'] as $component):
        ?>
        <script src="{{ URL::asset($component) }}" type="text/javascript"></script>
        <?php  endforeach;
        }
        }
        else{
        if(!empty($asset) && strpos('.js', $asset)){?>
        <script src="{{ URL::asset($asset) }}" type="text/javascript"></script>
        <?php } }
        endforeach;
        ?>
    @endif
    @yield('head')
</head>

<body class="production">
{{--page loading gif html--}}
<div class="overlay">
    <div id="loading-img"></div>
</div>
@include('partials.upgrade_plan_alert')
{{--main page content section--}}
@yield('content')

</body>
@include('layouts.footer_scripts')


@yield('last_scripts')


</html>
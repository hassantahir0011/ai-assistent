
<meta charset="utf-8"/>
<title>{{ config('app.name') }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="" name="description"/>
<meta content="" name="author"/>

{{--<script src="{{ URL::asset('assets/global/plugins/pace/pace.min.js') }}" type="text/javascript"></script>--}}
{{--<link href="{{ URL::asset('assets/global/plugins/pace/themes/pace-theme-flash.css', null, true) }}" rel="stylesheet" type="text/css" />--}}
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css', null, true) }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css', null, true) }}" rel="stylesheet" type="text/css" />
{{--<link href="{{ URL::asset('assets/global/plugins/bootstrap-taginput/bootstrap-taginput.css', null, true) }}" rel="stylesheet" type="text/css" />--}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />

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

<link href="{{ URL::asset('assets/global/plugins/bootstrap-toastr/toastr.min.css', null, true) }}" rel="stylesheet" type="text/css" />

<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{ URL::asset('assets/global/css/components-md.min.css', null, true) }}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{ URL::asset('assets/global/css/plugins-md.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<link href="{{ URL::asset('assets/apps/css/inbox.min.css', null, true) }}" rel="stylesheet" type="text/css" />

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{ URL::asset('assets/layouts/layout/css/layout.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/layouts/layout/css/themes/darkblue.min.css', null, true) }}" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{ URL::asset('assets/layouts/layout/css/custom.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<!-- THEME BRANDING CUSTOM STYLES -->
<link href="{{ URL::asset('assets/layouts/layout/css/branding-styles.css', null, true) }}" rel="stylesheet" type="text/css" />

<!-- END THEME STYLES -->


<!-- BEGIN PAGE LEVEL STYLES -->
{{--<link href="{{ URL::asset('assets/pages/css/profile.min.css', null, true) }}" rel="stylesheet" type="text/css" />--}}
{{--<link href="{{ URL::asset('assets/apps/css/ticket.min.css', null, true) }}" rel="stylesheet" type="text/css" />--}}
<!-- END PAGE LEVEL STYLES -->

<link href="{{ URL::asset('assets/global/plugins/select2/css/select2.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/select2/css/select2-bootstrap.min.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/global/plugins/animate/animate.css', null, true) }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/pages/css/error.min.css', null, true) }}" rel="stylesheet" type="text/css" />

<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>


{{--<link href="{{ URL::asset('assets/pages/css/blog.min.css') }}" rel="stylesheet" type="text/css"/>--}}
{{--<link href="{{ URL::asset('assets/global/plugins/cubeportfolio/css/cubeportfolio.css', null, true) }}" rel="stylesheet" type="text/css"/>--}}



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
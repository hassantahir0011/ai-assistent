<!DOCTYPE html>
<html lang="en">
<head >
    @include('layouts.head')
    @yield('head')
</head>

<body class="production">
{{--page loading gif html--}}
<div class="overlay">
    <div id="loading-img"></div>
</div>

<div class="wrapper">
    @include('partials.header')

    <div id="section-parent-container" class="container-fluid content-section-bg">
        <div class="container-box">
<!--                @include('partials.left-navbar')-->
            <div class="right-content-section">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('partials.upgrade_plan_alert')
{{--main page content section--}}


</body>
@include('layouts.footer_scripts')


@yield('last_scripts')

@if(empty(getenv('DEV_DISABLE_TAWK_TO')))
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5f44cabdcc6a6a5947ae8eef/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

@endif

</html>
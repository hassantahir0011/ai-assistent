<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.partials.head')
    @yield('head')

</head>
<!-- END HEAD -->

<body class="page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo page-content-white page-md">
<div class="page-wrapper">
    <div id="messages"></div>
    <!-- BEGIN HEADER -->
    @include('admin.partials.header')
            <!-- END HEADER -->
    <div class="clearfix"></div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        @include('admin.partials.sidebar')
                <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content-wrapper">
            <!-- Page Content start -->
            <div class="page-content">
                @yield('breadcrumb')
                <br clear="both">
                @include('admin.flash.message')
                @yield('content')
            </div>
        </div>
        <!-- END CONTENT BODY -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
        {{--@include('partials.quickbar')--}}
                <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    @include('admin.partials.footer')
            <!-- END FOOTER -->
</div>

@include('admin.partials.footer_script')

@yield('last_scripts')


</body>
</html>

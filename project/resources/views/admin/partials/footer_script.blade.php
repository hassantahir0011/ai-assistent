
<script src="{{ URL::asset('assets/apps/beforeapp.js') }}" type="text/javascript"></script>


{{--// include dynamic js files--}}
@if(isset($asset_controls) && !empty($asset_controls))
    <?php
    foreach(array_unique($asset_controls) as $asset):
    if(!empty($components = get_asset_components($asset, 'js'))){
    if(isset($components['before-appjs']) && !empty($components['before-appjs'])){
    foreach($components['before-appjs'] as $component):
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

            <!-- BEGIN THEME GLOBAL SCRIPTS -->

    <script src="{{ URL::asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/scripts/oric.js?v=15') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
    @if(isset($asset_controls) && !empty($asset_controls))
        <?php foreach(array_unique($asset_controls) as $asset):
        if(!empty($components = get_asset_components($asset, 'js'))){
        if(isset($components['after-appjs']) && !empty($components['after-appjs'])){
        foreach($components['after-appjs'] as $component):
        ?>
        <script src="{{ URL::asset('assets/'.$component) }}" type="text/javascript"></script>
        <?php  endforeach;
        }
        }

        endforeach;?>
@endif

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>--}}
    <script type="text/javascript">
        // Highlight Active Menu Script By Hassan
        $('.sub-menu li a').each(function () {
            var linktext = $(this).attr('href');
            if (linktext.search(window.location.search.substring(1)) > 1) {
                $('.sub-menu li.active').removeClass('active');
                $(this).closest('li').addClass('active');
            }
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            var scripts = document.getElementsByTagName("script");
            for (var i = 0; i < scripts.length; i++) {
                var str = scripts[i].getAttribute('src');
                if (str && str.includes("select2.v4")) {
                    $('.select2-multiple').select2();
                }
            }



        });

    </script>

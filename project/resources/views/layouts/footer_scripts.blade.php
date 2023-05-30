<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script src="{{ URL::asset('css/appdesign/js/main.js', null, true) }}" type="text/javascript"></script>


<script src="{{ asset('js/helper_functions.js') }}" type="text/javascript"></script>
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

@if(isset($asset_controls) && !empty($asset_controls))
    <?php foreach(array_unique($asset_controls) as $asset):
    if(!empty($components = get_asset_components($asset, 'js'))){
    if(isset($components['after-appjs']) && !empty($components['after-appjs'])){
    foreach($components['after-appjs'] as $component):
    ?>
    <script src="{{ URL::asset($component) }}" type="text/javascript"></script>
    <?php  endforeach;
    }
    }

    endforeach;?>
@endif
<script type="text/javascript">
    // toaster options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "showEasing": "easeOutBounce",
        "hideEasing": "easeInBack",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    @if($response_message = session('message'))
    toastr.info('{{ $response_message }}');
    @endif

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error('{{ $error }}');
    @endforeach
    @endif
    $(document).ready(function () {
        $(document).on("mouseenter", ".connectify-tooltip-container", function () {
            var eTop = $(this).offset().top;
            var scroll_top = eTop - $(window).scrollTop();
            var tool_tip_contect_div = $(this).find('.connectify-tooltip');
            if (scroll_top < tool_tip_contect_div.outerHeight()) {
                tool_tip_contect_div.addClass("pos-bottom");
            } else {
                tool_tip_contect_div.removeClass("pos-bottom");
            }
        });
        $('[data-toggle="tooltip"]').tooltip({
            placement : 'right'
        });
        jQuery(function($) {
            $(".icon-menu").click(function() {
                $('.left-menu-collapes').toggleClass("menu-visible");
                $('.right-content-section').toggleClass("content-offset" );
            });
        });

        let current_url = window.location.pathname;
        //parent of current select nav sub-item
        let select_nav_parent=$("#nav a[href*='"+current_url+"']").parent();
        select_nav_parent.addClass("active-menu");
        if(select_nav_parent.parent().parent().hasClass('collapse')){
            // to open parent div
            select_nav_parent.parent().parent().addClass('in').attr('aria-expanded',true).css({'height':""});
            // to change parent nav arrow icon position upword in case of  child li(nav) selected
            select_nav_parent.parent().parent().prev('li').find('a.nav-link').removeClass('collapsed');
        }


        $('.bar-close-icon').click(function () {
            $('.notification-bar').fadeOut(300);
        });

        /*var windowWidth = $(window).width();
        if(windowWidth <= 768){
            $('.user-profile-parent-div').click(function () {
                $(".user-profile-for-mobile").slideToggle(200);
                $('.desktop-scr-signoutBtn').children().appendTo(".user-profile-for-mobile");

            });
        } else{
            $('.mobile-scr-signoutBtn').css("display","none");
            $('.user-profile-parent-div').click(function () {
                $(".desktop-scr-signoutBtn").slideToggle(200);
            });
        }*/
        $('.notification-bar').css("display","inline-flex");
    });
</script>

<script>
    $(document).ready(function() {
        $('.form-select').select2();
    });
</script>


<main role="main">
    <section class="section">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="connector_account_page_settings">
                    <div class="connector_account_page_body">
                        <div class="Polaris-Card__Header header_design">
                            <div class="header_img">
                                <img src="{{ config('channel.icon_path')  }}">
                            </div>
                            <h2 class="mb-2">Choose channel account</h2>
                            <p class="mb-3"> All webhooks will be triggered to that account's modules.</p>
                        </div>
                        <div class="multiple_account_tree">
                            <ul>
                                @if(count($channel_accounts) > 0)
                                <li class="mb-0">
                                    <h6>Your Connected Account</h6>
                                </li>
                                @endif
                                @foreach($channel_accounts as $channel_account )
                                    @php $current_account=$channel_event_settings &&
                                                $channel_event_settings->channel_account_id==$channel_account->id?true:false;
                                    @endphp
                                    <li class="{{ $current_account?"active":""  }} d-block">
                                        <div class="links_inner_div">
                                            <a data-channel_account_id="{{$channel_account->id  }}"
                                               href="javascript:"
                                               class="choose-account single_account_settings">
                                                <div class="fb-user-img">
                                                    <img src="{{ config('channel.icon_path') }}"
                                                         alt="user-image">
                                                </div>
                                                <div class="content_div">
                                                    {{--get first key value of login credentials array--}}
                                                    <h4>{{ (current($channel_account->login_credentials)??"") }}</h4>
                                                    {{--get 2nd value of login credentials--}}
                                                    <p>{{ array_values($channel_account->login_credentials)[1]??"" }}
                                                        @if(config('channel.custom_app_option'))
                                                            @if($channel_account->custom_app_id)
                                                                (custom app)
                                                            @else
                                                                 ({{ config('app.name') }} app)
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>

                                                @if($current_account)
                                                    <ul>
                                                        <li class="fb_check_circle">
                                                            <i class="fa fa-check-circle" aria-hidden="true"
                                                               style=""></i>
                                                            <h5>Continue with this account...</h5>
                                                        </li>
                                                    </ul>
                                                @endif
                                            </a>

                                            <div data-account-id="{{ $channel_account->id }}"
                                                 class="delete_account sign_out_btn">
                                                <button href="javascript:"><i class="fal fa-trash"></i></button>
                                            </div>
                                            @if(config('channel.is_channel_account_editable'))
                                                @if(!$channel_account->custom_app_id)
                                                    <div
                                                            data-url="{{route(config('channel.name')."_account_login",["id"=>$channel_account->id,"account_type_splash_window"=>1])}}"
                                                            data-id="{{$channel_account->id}}"
                                                            class="update_btn update-channel-account ">
                                                        <button href="javascript:"><i
                                                                    class="fal fa-pencil-square-o"></i></button>
                                                    </div>
                                                @else
                                                    <div
                                                            data-url="{{route(config('channel.name')."_app_account",["id"=>$channel_account->id,"account_type_splash_window"=>1])}}"
                                                            class="update_btn update-channel-account">
                                                        <button href="javascript:"><i
                                                                    class="fal fa-pencil-square-o"></i></button>
                                                    </div>

                                                @endif
                                            @endif
                                        </div>
                                        @if($channel_account->expired)
                                            <small class="text-danger text-left d-block">{{"Authentication failed : ".$channel_account->exception_message}}</small>
                                        @endif
                                    </li>
                                @endforeach
                                <li class="pt-4 mb-0">
                                    <h6>Add new Account</h6>
                                </li>
                                @if(config('channel.custom_app_option'))
                                    <li>
                                        <div class="form-check checkbox">
                                            <input class="form-check-input" type="radio" name="option"
                                                   id="flexRadioDefault1" value="1"
                                                   data-url="{{route(config('channel.name')."_account_login",["account_type_splash_window"=>1])}}"
                                            >
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Continue with {{ config('app.name') }} app
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check checkbox">
                                            <input class="form-check-input" type="radio" value="2" name="option"
                                                   id="flexRadioDefault2"
                                                   data-url="{{route(config('channel.name')."_app_account")}}">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Continue with your own app
                                            </label>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <a href="javascript:"
                                           data-url="{{route(config('channel.name')."_account_login",["account_type_splash_window"=>1])}}"
                                           class="channel-new-login connect_new_account">
                                            <div class="add-account-icon">
                                                <i class="fa fa-plus-circle"></i>
                                            </div>
                                            <h5>Connect a new account</h5>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="alert alert-warning text-center">
                            <p>Login with multiple accounts to access their workbooks.You can only remove
                                accounts by first removing all associated webhooks with it.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@section('last_scripts')
    <script>
        // response callback function from child new mysql connection popup window
        function channelPopupCallback(response) {
            toastr.success(response);
            window.location.reload();
        }


        $(document).on('click', '.channel-new-login,.update-channel-account', function () {
            var url = $(this).data('url');
            var popname = window.open(url, 'channelAccountWindow', 'toolbar=no,location=no,status=1,menubar=no,scrollbars=yes,resizable=yes,width=800,height=500');
            popname.window.focus();
        });
        $(document).on('click', '.choose-account', function () {
            window.location.href = window.location.href + (window.location.search ? '&' : '?') + 'channel_account_id=' + ($(this).data('channel_account_id'));
        });


        @if(config('channel.custom_app_option'))
        $('input:radio').click(function () {
            var url = $(this).data('url');
            var value = $(this).val();
            if (value == 1) {

                var popname = window.open(url, 'channelAccountWindow', 'toolbar=no,location=no,status=1,menubar=no,scrollbars=yes,resizable=yes,width=800,height=500');
                popname.window.focus();

            } else {
                var popname = window.open(url, 'channelAccountWindow', 'toolbar=no,location=no,status=1,menubar=no,scrollbars=yes,resizable=yes,width=800,height=500');
                popname.window.focus();
            }

        });
        @endif

        $(document).on('click', '.delete_account', function () {
            show_loading_img();
            let id = $(this).data('account-id');
            $.ajax({
                url: "{{ route('remove_channel_account')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "<?= Session::token() ?>"
                },
                dataType: "JSON",
                data: {
                    id: id
                },
                cache: false,
                success: function (response) {
                    hide_loading_img();
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        window.location.href = window.location.href;
                    } else {
                        toastr.error(response.message);
                    }
                }, error: function (result) {
                    hide_loading_img();
                    toastr.error('Unable to remove account.Please signin again');

                },
                timeout: 1000000
            }).fail(function (jqXHR, textStatus) {
                hide_loading_img();
                toastr.error('Unable to remove account.Please signin again');
            });
        });
    </script>
@endsection
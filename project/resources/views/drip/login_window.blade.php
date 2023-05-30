@extends('layouts.popup_window_parent')
<?php $asset_controls = ['validation'];?>
@section('content')
    <main role="main">
        <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
            <div class="Polaris-Page create ">
                <div class="Polaris-Page__MainContent">
                    <div class="Polaris-Page__Content">
                        <div class="Polaris-Layout">
                            <div class="Polaris-Layout__Section">
                                <div class="Polaris-Card">
                                    <div class="inner-content-fullWidth">
                                        <div class="Polaris-Card card-bg-color">
                                            <div class="Polaris-Card__Header header_design">
                                                <div class="header_img">
                                                    <img src="{{ asset('icons/drip.png') }}">
                                                </div>
                                                <h4 class="">Allow Connectify to access your Drip Account</h4>
                                                <div class="error-messages alert alert-danger" role="alert"
                                                     style="display:none;">
                                                </div>

                                            </div>
                                            <div class="channel-presentation-div">
                                                <form id="connect-drip-form" method="post" onsubmit="return false"
                                                      action="{{ route('store_drip_account') }}" >
                                             <input id="account_id" type="hidden" name="account_id" value="{{ $account?$account->id:0 }}">


                                                    <div class="fields-wrapper">
                                                        <div class="Polaris-Labelled__LabelWrapper">
                                                            <div class="Polaris-Label">
                                                                <label id="PolarisTextField2Label"
                                                                       for="PolarisTextField2"
                                                                       class="Polaris-Label__Text">API Token
                                                                    <span style="font-size: 12px;color: red;">(required)</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="Polaris-Connected">
                                                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                                <div class="Polaris-TextField">
                                                                    <input id="api_token"
                                                                           class="Polaris-TextField__Input"
                                                                           type="text"
                                                                           value="{{ old('api_token')?old('api_token'):($login_credentials['api_token']??'') }}"
                                                                           data-rule-required="true"
                                                                           name="api_token">
                                                                    <div class="Polaris-TextField__Backdrop"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Polaris-Labelled__HelpText"
                                                             id="PolarisTextField2HelpText"><span>
                                                               Get API Token by logging into your drip account and  <a target="_blank" href="https://www.getdrip.com/user/edit">go to this url</a> </span>
                                                        </div>
                                                    </div>
                                                    <div class="save-btn" style="margin: 19px 0;">
                                                        <button id="form-sybmit-btn" type="submit" class="Polaris-Button">
                                                            <span class="Polaris-Button__Content">
                                                                <span class="Polaris-Button__Text">{{ $account?"Update":"Add" }}</span></span>
                                                        </button>
                                                    </div>
                                            </form>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('last_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            oric_Validation_application("connect-drip-form",undefined,undefined,true);
            function register_drip_account() {
                show_loading_img();
//                $('#form-sybmit-btn').attr('disabled',true);
                $.ajax({
                    url: "{{ route('store_drip_account')}}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "<?= Session::token() ?>"
                    },
                    dataType: "JSON",
                    data: {
                        api_token: $('#api_token').val(),
                        account_id: $('#account_id').val()
                    },
                    cache: false,
                    success: function (response) {
                        hide_loading_img();
                        if(response.status=='success'){
                            window.opener.channelPopupCallback(response.message); //Call callback function
                            window.close(); // Close the current popup
                        }
                        else if(response.status=='error' &&  response.errors){
                            $('.error-messages').empty().show();
                            let errors=response.errors;
                            for(var i in errors){
                                $('.error-messages').append('<p>'+errors[i].message+'</p>');
                            }
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $('#form-sybmit-btn').attr('disabled',false);

                        }


                    }, error: function (result) {
                        $('.error-messages').empty().show();
                        $('.error-messages').append('<p>Unable to save.Please try again later.</p>');
                        hide_loading_img();
                        $('#form-sybmit-btn').attr('disabled',false);

                    },
                    timeout: 1000000
                }).fail(function (jqXHR, textStatus) {
                    hide_loading_img();
                    $('.error-messages').empty().show();
                    $('.error-messages').append('<p>Unable to save.Please try again later.</p>');
                    $('#form-sybmit-btn').attr('disabled',false);


                });
            }
            $("#connect-drip-form").submit(function (e) {
                e.preventDefault();
                if ($('#connect-drip-form').valid()) {
                    register_drip_account();
                }else{
                    alert('Please fill required field values');
                }

            });
        });
    </script>
@endsection

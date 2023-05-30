<main role="main">
    <div class="page-div-myStyle">
        <div class="container">
            <div class="event-setup-page">
                <ul class="Polaris-Tabs">
                    <li class="Polaris-Tabs__TabContainer">
                        <button type="button"
                                class="Polaris-Tabs__Tab Polaris-Tabs__Tab--selected"
                                data-id="snippet-settings-section"><span
                                    class="Polaris-Tabs__Title">General</span>
                        </button>
                    </li>
                    @if($webhook_event_conditions)
                        <li class="Polaris-Tabs__TabContainer">
                            <button type="button"
                                    class="Polaris-Tabs__Tab "
                                    data-id="conditions-section"><span
                                        class="Polaris-Tabs__Title condition-section-title">Conditions</span>
                            </button>
                        </li>
                    @endif
                    @if($guide_available)
                        <li class="Polaris-Tabs__TabContainer">
                            <button type="button"
                                    class="Polaris-Tabs__Tab guide-tab-btn"
                                    data-id="guide-overview-section"><span
                                        class="Polaris-Tabs__Title">Guide</span>
                            </button>
                        </li>
                    @endif
                </ul>
                <form id="event-form" method="post"
                      @if(!$registered_webhook)
                          action="{{ route('store_general_event_config') }}"
                      @else
                          action="{{ route('update_general_event_config',[$registered_webhook->id]) }}"
                      @endif
                      enctype="multipart/form-data">
                    <input type="hidden" name="channel_account_id"
                           value="{{ $_GET['channel_account_id']??'' }}">
                    <div class="">
                        <div class="event-inner-content">
                            <div id="snippet-settings-section"
                                 class="">
                                @include('channel.partials.general')
                            </div>
                            @if($webhook_event_conditions)
                                <div style="border-top: none; display:none" id="conditions-section"
                                     class="Polaris-Card__Section ">
                                    @include('partials.conditional_execution_partial')
                                </div>
                            @endif
                            @if($guide_available)
                                <div id="guide-overview-section"
                                     class="">
                                </div>
                            @endif
                        </div>
                        <div class="connector-setup-btn" id="snippet-install-action-bar">
                            <button type="submit" class="update-btn-setup-page"><span
                                        class="Polaris-Button__Content"><span
                                            class="Polaris-Button__Text">{{ $registered_webhook?'Update':'Save' }}</span></span>
                            </button>
                            @if(isset($_GET['retry_id']))
                                <button type="button" class="retry-failed-job-button"
                                        data-retry-action="{{ route('retry_failed_webhook',$_GET['retry_id']) }}"><span
                                            class="Polaris-Button__Content"><span
                                                class="Polaris-Button__Text">Retry</span></span>
                                </button>
                            @elseif($registered_webhook)
                                <button type="button" class="test-action-btn"><span
                                            class="Polaris-Button__Content"><span
                                                class="Polaris-Button__Text">Test Action</span></span>
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>



@section('last_scripts')
    {{--include form validation,tab selection and guide script--}}
    @include('partials.last_js_scripts')

    {{--each channel js--}}
    @include(config('channel.name').".js_scripts")
@endsection


<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
<div class="">
    <div class="">
        <div class="">
            <div class="card-bg-color">
                <div class="event-header-content">
                    <div class="channel-details-div">
                        <div class="channel-icon">
                                                <span class="app-integration-summary-ico">
                                                    <span class="service-icon-shell my-style">
                                                        <img alt="{{ config('channel.name') }} logo"
                                                             aria-hidden="false" class=""
                                                             src="{{ config('channel.icon_path') }}"
                                                        >
                                                    </span>
                                                </span>
                        </div>
                        <div class="channel-name-dec-div">
                            <span> {{ ucwords(str_replace('_', ' ', config('channel.name'))) }}</span>
                            <h3>Register {{ $webhook_event->event_name??'' }} Webhooks </h3>
                        </div>
                    </div>
                </div>
                <div class="connector-setup-page-wrapper">

                    <div class="connector-setup-page-section">
                        @php $response_message = session('message');@endphp
                        <div class="test-action-response alert alert-success alert-dismissible " role="alert"
                                {!!   empty($response_message)?' style="display:none"':'' !!} >
                            <strong id="test-action-status"></strong>
                            <span id="test-action-message">
                                        {{ $response_message??'' }}
                                    </span>
                            <button type="button" class="response_close_btn close close-test-action-btn"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <h4 class="connector-heading">Choose Webhook Topic &amp; {{ ucwords(str_replace('_', ' ', config('channel.name'))) }} Event</h4>

                        <br>

                        <div class="Polaris-Labelled__LabelWrapper">
                            <div class="Polaris-Label right-required-text-label">
                                <label id="PolarisTextField2Label"
                                       for="PolarisTextField2"
                                       class="Polaris-Label__Text">Select Webhook Topic
                                    <span>(required)</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            {{--// specific webhook topic for this connector,delete events are not supported --}}
                            @php $channels_allowed_event_topics=config("channels_allowed_event_topics.".config('channel.name').".$webhook_event->event_name")??[]; @endphp
                            <select data-webhook-event-name="{{ $webhook_event->event_name }}" id="webhook_topic_id"
                                    name="webhook_topic_id"
                                    class="form-control"
                                    data-rule-required="true">
                                <option value="">Choose...
                                </option>
                                @foreach($webhook_topics as $webhook_topic )
                                    @if(empty($channels_allowed_event_topics) || in_array($webhook_topic->topic_name,$channels_allowed_event_topics) )
                                        <option
                                                {{ (old('webhook_topic_id')==$webhook_topic->id) || ($registered_webhook && $registered_webhook->webhook_topic_id==$webhook_topic->id)?'selected':'' }}
                                                value="{{ $webhook_topic->id }}">{{ $webhook_topic->topic_name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        @include('partials.channel_events')

                    </div>
                    {{-- load section fields and values--}}
                    {{--<h4>Event Table body</h4>--}}
                    <div id="channel-fields-section">

                    </div>

                    <div class="connector-setup-page-section">


                        <div class="Polaris-Labelled__LabelWrapper">
                            <div class="Polaris-Label right-required-text-label">
                                <label id="PolarisTextField2Label"
                                       for=""
                                       class="Polaris-Label__Text">Description
                                    <span>(optional)</span>
                                </label>
                            </div>
                        </div>
                        <div class="Polaris-Connected">
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                <div class="Polaris-TextField">
                                                    <textarea id="" class="Polaris-TextField__Input"
                                                              rows="2"
                                                              aria-describedby="PolarisTextField2HelpText"
                                                              name="description"
                                                              aria-labelledby="PolarisTextField2Label"
                                                              aria-invalid="false"
                                                              aria-multiline="false">{{ old('description')?old('description'):($registered_webhook?$registered_webhook->description:'') }}</textarea>
                                    <div class="Polaris-TextField__Backdrop"></div>
                                </div>
                            </div>
                        </div>

                        <div class="toggle_btn_style">
                            <div class="Polaris-Labelled__LabelWrapper">
                                <div class="Polaris-Label">
                                    <label for="shopify-products-filterTitle"
                                           class="Polaris-Label__Text">
                                                            <span id="enable-disable-tour"
                                                                  class="app-label">Enable</span>
                                    </label>
                                    <label class="switch">
                                        <input type="checkbox" name="status" value="enabled"
                                               {{ $registered_webhook && $registered_webhook->status==1?"checked":'' }}
                                               id="status">
                                        <div class="slider round">
                                            <!--END--></div>
                                    </label>
                                    <div class="Polaris-Labelled__HelpText"
                                         id="PolarisTextField2HelpText">
                                                        <span>
                                                            You can enable it later after testing this hook by clicking <b>Test Action</b> button below.Button will be appeared after saving configuration.
                                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
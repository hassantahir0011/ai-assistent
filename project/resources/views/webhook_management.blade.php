@extends('layouts.master')
@section('content')

    <main id="main">


            <div class="banner overflow-hidden">
                <div class="container">
                    <div class="mainbox">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="banner-text">
                                    <h1>Connect & automate workflows between shopify store and {{ str_replace("_", " ", config('channel.name')) }} </h1>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box p-5">
                                    <img src="https://connector.shopifypioneer.com/ai-rizwan/css/appdesign/images/bannerImg.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mainbox">
                                <canvas id="myChart"></canvas>
                            </div>
                            @if(count($register_webhooks))
                                <div class="mainbox mb-4">
                                    <div class="row">
                                        <h5>Registered Webhooks</h5>
                                        <div class="col-md-12">
                                            <table class="table bordered">
                                                <thead>
                                                <tr>
                                                    <th>Channel</th>
                                                    <th>Name</th>
                                                    <th>Webhook</th>
                                                    <th>Event Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($register_webhooks as $register_webhook)
                                                    <tr>
                                                        <td width="50" >
                                                            <div class="img-box">
                                                                <img src="{{ config('channel.icon_path') }}" alt="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span>{{ ucwords(str_replace("_", " ", config('channel.name'))) }}</span>
                                                        </td>
                                                        <td>{{ ucwords(str_replace("/", " -> ", $register_webhook->topic_name)) }}</td>
                                                        @php
                                                            $event_name = $register_webhook->channel_event_settings->channel_event->name ?? ($register_webhook->channel_event_settings->object_text) ?? '';
                                                            if(strlen($event_name) > 35) $event_name = substr($event_name, 0, 30).'...';
                                                        @endphp
                                                        <td>{{ $event_name }}</td>
                                                        <td>
                                                            <label class="switch"><input data-action-target="{{ route('update_event_status'  ,[$register_webhook->id]) }}" type="checkbox" data-id="{{ $register_webhook->id }}" class="update-webhook-status" {{ $register_webhook->status ? 'checked' : '' }} ><div class="slider round" id="{{ $register_webhook->id }}"><span class="on">ON</span><span class="off">OFF</span></div> </label>
                                                        </td>
                                                        <td><a href="{{ route('channel_config'  ,[$register_webhook->webhook_event_slug,$register_webhook->id]) }}"><i class="fal fa-pencil-square-o"></i></a> </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(count($favorites))
                                <div class="mainbox">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Quickly Connect</h5>

                                            <div id="favorites">
                                                @foreach($favorites as $favorite)
                                                    <div class="card horizontally">
                                                        <div class="card-body">
                                                            <ul class="icon-list small">
                                                                <li>
                                                                    <div class="icon-box">
                                                                        <img src="https://appscorridor.com/webhook_setup_stage/css/appdesign/images/shopify-img.png">
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="icon-box">
                                                                        <img src="{{ config('channel.icon_path') }}">
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <p>{{ $favorite->message }} <a href="#">{{ ucwords(str_replace('_', ' ', config('channel.name'))) }}</a> </p>
                                                            <a href="{{ route('channel_config', [$favorite->webhook_event->slug]) }}" class="btn ">Try it</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="overflow-hidden">
                                                <a class="btn d-block" href="{{ route('automate') }}">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="mainbox mb-4">
                                <div class="YourplanCard p-0 bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-3 font-16">Your Plan</h4>
                                        <div class="mb-3">
                                            <a href="{{ route('plans_listing') }}" class="btn font-12">Upgrade your Plan <i class="fas fa-angle-right"></i> </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 py-3">
                                            <h6 class="font-14">Plan</h6>
                                            <div>
                                                    <span class="tag">
                                                        {{ ucfirst($shop->current_plan_type) }}
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 py-3">
                                            <h6 class="font-14">Next Billing Date</h6>
                                            {{ $plan_history_next_date }}
                                        </div>
                                        <div class="col-lg-6 py-3">
                                            <h6 class="font-14">Price</h6>
                                            ${{ $shop->current_plan_type == 'elite' ? 9 : ($shop->current_plan_type == 'professional' ? 5 : 0) }}
                                        </div>
{{--                                        <div class="col-lg-6 py-3">--}}
{{--                                            <h6 class="font-14">Tasks per month </h6>--}}
{{--                                            {{ number_format($allowed_webhooks_tasks) }} per month--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="mainbox  mb-4">
                                <div class="YourplanCard p-0 bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-3 font-16">Usage</h4>
{{--                                        <div class="mb-3">--}}
{{--                                            <div class="text-muted">Resets on {{ $plan_history_next_date }}</div>--}}
{{--                                        </div>--}}
                                    </div>
                                    @php
                                        $used = $shop->used_text_processed_jobs->sum('tokens') == ($shop->purchased_text_processed_jobs->sum('tokens') + config('shopify.trial_text_token')) ? 1000 : ($shop->used_text_processed_jobs->sum('tokens') ?? 0) % 1000;
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="fst-normal mt-3"><strong>{{ $used }}</strong> of {{ 1000 }} automations used</p>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" aria-label="Success example" style="width: {{ ($shop->purchased_text_processed_jobs->sum('tokens') + config('shopify.trial_text_token')) ?? 0 ? ($used/1000)*100 : 0 }}%" aria-valuenow="{{ $used }}" aria-valuemin="0" aria-valuemax="{{ 1000 }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mainbox d-none">
                                <div class="card mb-5">
                                    <div class="card-body p-0 bg-transparent">
                                        <ul class="icon-list">
                                            <li>
                                                <div class="icon-box" widhth="50">
                                                    <img src="https://appscorridor.com/webhook_setup_stage/css/appdesign/images/14.png">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon-box">
                                                    <img src="{{ config('channel.icon_path') }}" style="max-width: 40px">
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="text-center">
                                            <h5 class="text-blue my-3">Discover all the possible integrations for Shopify</h5>
                                            <a href="{{ route('automate') }}" class="btn">Discover</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-5">
                                        <div class="card">
                                            <div class="card-body  p-0 bg-transparent">
                                                <h6>Request An Integration</h6>
                                                <p>Can't find the software you're looking for? Dont't worry! We're constantly adding new intergrations based on our customer's requests. </p>
                                                <a target="_blank" href="mailto:support@connectify.co">Request an Integration</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>

    @include('partials.models_html')
{{--    <footer id="footer">--}}
{{--        <div class="container">--}}
{{--            <svg viewBox="0 0 20 20"  focusable="false" aria-hidden="true">--}}
{{--                <path fill-rule="evenodd" d="M18 10a8 8 0 1 0-16 0 8 8 0 0 0 16 0zm-9 3a1 1 0 1 0 2 0v-2a1 1 0 1 0-2 0v2zm0-6a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"></path>--}}
{{--            </svg>--}}
{{--            Learn more about--}}
{{--            <a href="https://connectify.co/" target="_blank" rel="noopener noreferrer" data-polaris-unstyled="true">CONNECTIFY--}}
{{--                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">--}}
{{--                    <path d="M14 13v1a1 1 0 0 1-1 1h-7c-.575 0-1-.484-1-1v-7a1 1 0 0 1 1-1h1c1.037 0 1.04 1.5 0 1.5-.178.005-.353 0-.5 0v6h6v-.5c0-1 1.5-1 1.5 0zm-3.75-7.25a.75.75 0 0 1 .75-.75h4v4a.75.75 0 0 1-1.5 0v-1.44l-3.22 3.22a.75.75 0 1 1-1.06-1.06l3.22-3.22h-1.44a.75.75 0 0 1-.75-.75z"></path>--}}
{{--                </svg>--}}
{{--            </a> at the--}}
{{--            <a href="{{ route('faqs') }}" target="_blank" rel="noopener noreferrer" data-polaris-unstyled="true" class="Polaris-Link">Help Docs--}}
{{--                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">--}}
{{--                    <path d="M14 13v1a1 1 0 0 1-1 1h-7c-.575 0-1-.484-1-1v-7a1 1 0 0 1 1-1h1c1.037 0 1.04 1.5 0 1.5-.178.005-.353 0-.5 0v6h6v-.5c0-1 1.5-1 1.5 0zm-3.75-7.25a.75.75 0 0 1 .75-.75h4v4a.75.75 0 0 1-1.5 0v-1.44l-3.22 3.22a.75.75 0 1 1-1.06-1.06l3.22-3.22h-1.44a.75.75 0 0 1-.75-.75z"></path>--}}
{{--                </svg>--}}
{{--            </a>.--}}
{{--        </div>--}}
{{--    </footer>--}}
@endsection
@section('last_scripts')

    <script type="text/javascript">
        {{--scripts here--}}
        $(document).on('change', '.update-webhook-status', function () {
            var element=$(this);
            if ($(this).prop('checked')) {
                var status=1;
            }else{
                var status=0;
            }

            show_loading_img();

            $.ajax({
                url: element.attr('data-action-target'),
                type: 'POST',
                data: {
                    _method: 'POST',
                    _token: "<?= Session::token() ?>",
                    status:status,
                    id:element.data('id')
                },
                cache: false,
                success: function (result) {
                    if (result && result.status=='success') {
                        toastr.success(result.message)
                        // callSwalWithHTML(result.status, result.message, 'success');
                    }else{
                        toastr.error(result.message)
                        // callSwalWithHTML(result.status, result.message, 'error');
                        element.prop('checked', status==1?false:true);
                    }
                    hide_loading_img();
                }, error: function (response) {
                    toastr.warning('Failed to update . Try again !!')
                    // swal('Warning', 'Failed to update . Try again !!', 'warning');
                    element.prop('checked', status==1?false:true);
                    hide_loading_img();},
                timeout: 15000
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'timeout') {
                    toastr.error('Please Wait... Slow connection!')
                    // swal("Sorry", 'Please Wait... Slow connection!', "error");
                    element.prop('checked', status==1?false:true);
                }hide_loading_img();
            });
        })
    </script>

    <script>
        // Data for the chart
        const data = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'My Dataset',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Configuration options
        const options = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Create the bar chart
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>

@endsection

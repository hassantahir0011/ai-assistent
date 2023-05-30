@extends('layouts.master')

@section('content')


    <main id="main" class="pb-5">

        <section class="section mb-5 section-banner">
            <div class="container">
                <h1>Make an Automation</h1>
                <form class="row">
                    <div class="col-md-10">
                        <div class="colRow">
                            <div class="col">
                                <div class="form-group">
                                    <label>Choose Webhook</label>
                                    <select name="" class="form-select" id="webhook_event_id">
                                        @foreach($webhook_events as $webhook_event)
                                            <option value="{{ $webhook_event->slug }}">{{ preg_replace('/(?<!\ )[A-Z]/', ' $0', $webhook_event->event_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col-md-3">
                                    <button id="create_btn" type="button" style="margin:24px 0 0">Connect</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        @if(count($favorites))
            <section class="section mb-4">
                <div class="container">
                    <h2>Quickly Connect</h2>
                    <div class="row">
                        @foreach($favorites as $favorite)
                            <div class="col-lg-3 col-md-4 mb-3">
                                <div class="card h-100 ">
                                    <a href="{{ route('channel_config', [$favorite->webhook_event->slug]) }}" class="card-body bg-white bottom-fixed">
                                        <ul class="icon-list small mb-3">
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
                                        <p>{{ $favorite->message }} <span>{{ ucwords(str_replace('_', ' ', config('channel.name'))) }}</span> </p>
                                        <div  class="card-footer">
                                            <div>
                                                Shopify <i class="fas fa-plus d-inline mx-2 font-14"></i>{{ ucwords(str_replace('_', ' ', config('channel.name'))) }}
                                            </div>
                                            <div><span class="tryit">Try it</span><i class="fal fa-long-arrow-right"></i></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="mainbox">
                            <div class="helpSection">
                                <div class="img-box">
                                    <img class="media-img" alt="in app support" width="100%" height="100%" src="{{ asset('icons/help&guide_icon.png') }}" style="object-fit: contain; object-position: center center;">
                                </div>
                                <div class="description">
                                    <h4>Do you have any queries or need help?</h4>
                                    <p>You can reach out live support or send us an email.We'll get back to you shortly.</p>
                                    <a class="btn" href="mailto:support@connectify.co">Send an Email</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

@endsection
@section('last_scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $( "#create_btn" ).click(function() {
                let webhook_event_id = $( "#webhook_event_id" ).val();

                window.location.replace("channel_config/"+webhook_event_id);
            });
        });
    </script>
@endsection

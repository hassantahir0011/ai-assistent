<div class="tab-pane" id="popular-app-tab">
    <div class="apps-channels">
        <ul>
            @foreach($channels as $channel)
                @if($channel->is_popular)
                <li class="item-resize-01">
                    <div class="app-integration ">
                        <a data-channel_id="{{ $channel->id }}" href="javascript:" class="app-integration-links">
                            <div class="parent-shall">
                                <div class="service-icon-shell">
                                    <img alt="{{ $channel->name }}" aria-hidden="false" class="" src="{{ $channel->icon_path }}">
                                </div>
                            </div>

                            <div class="app-icon-details">
                                <h3 class="app-integration-name">{{ ucwords(str_replace('_',' ',$channel->name)) }}</h3>
                            </div>
                        </a>
                    </div>
                </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<div class="tab-pane" id="all-app-tabs">
    <div class="apps-channels">
        <ul>
            @foreach($channels as $channel)
                <li class="item-resize-01">
                    <div class="app-integration ">
                        <a data-channel_id="{{ $channel->slug }}" href="javascript:" class="app-integration-links">
                            <div class="parent-shall">
                                <div class="service-icon-shell">
                                    <img alt="{{ $channel->name }}" aria-hidden="false" class="" src="{{ $channel->icon_path }}" />
                                </div>
                            </div>

                            <div class="app-icon-details">
                                <h3 class="app-integration-name">{{ ucwords(str_replace('_',' ',$channel->name)) }}</h3>
                            </div>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>

    </div>
</div>

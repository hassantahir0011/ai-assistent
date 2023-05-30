 <div class="Polaris-Labelled__LabelWrapper">
        <div class="Polaris-Label right-required-text-label">
            <label id="PolarisTextField2Label"
                   for="PolarisTextField2"
                   class="Polaris-Label__Text">Select channel Event
                <span style="font-size: 12px;color: red;">(required)</span>
            </label>
        </div>
    </div>
    <div class="form-group mb-none ">
        <select id="channel_event_id" name="channel_event_id"
                class="form-control " data-rule-required="true">
            <option value="">Choose...</option>
            @foreach(channel_events() as $channel_event)
                <option data-slug="{{ $channel_event->slug }}"
                        {{ (old('channel_event_id')==$channel_event->id) || ($channel_event_settings && $channel_event_settings->channel_event_id==$channel_event->id)?"selected":"" }}
                        value="{{$channel_event->id}}">{{ $channel_event->name }}</option>
            @endforeach
        </select>
    </div>



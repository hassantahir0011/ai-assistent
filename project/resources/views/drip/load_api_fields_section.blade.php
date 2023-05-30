@switch($channel_event->slug)
    @case("add_or_update_subscriber")
    @include('drip.add_or_update_subscriber')
    @break
    @case("remove_people_from_campaign")
    @include('drip.remove_people_from_campaign')
    @break
    @case("add_tag_to_subscriber")
    @case("remove_tag_from_subscriber")
    @include('drip.add_or_remove_tag_to_subscriber')
    @break
    @case("add_people_to_campaign")
    @include('drip.add_people_to_campaign')
    @break
    @default
    <div class="connector-setup-page-section">
    <span>Something went wrong, please try again</span>
    </div>
@endswitch


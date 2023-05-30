<?php


//if (!function_exists('facebook_events')) {
//
//    function facebook_events($status = 1)
//    {
//        return \App\Entities\FacebookEvent::where('status', $status)->get();
//    }
//}
//
//if (!function_exists('twitter_events')) {
//
//    function twitter_events($status = 1)
//    {
//        return \App\Entities\TwitterEvent::where('status', $status)->get();
//    }
//}
//
//if (!function_exists('google_contact_events')) {
//
//    function google_contact_events($status = 1)
//    {
//        return \App\Entities\GoogleContactEvent::where('status', $status)->get();
//    }
//}

if (!function_exists('channel_events')) {

    function channel_events($status = 1)
    {
        return \App\Entities\ChannelEvent::where('status', $status)->get();
    }
}


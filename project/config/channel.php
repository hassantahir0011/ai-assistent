<?php

return [
    /*
    |----------------------------------------------------------------------------
    | Constants variables
    |----------------------------------------------------------------------------
    */
//marketo credential variables starts here

    "name" => env('channel_name', "drip"),
    "icon_path" => env('channel_icon_path', "https://connector.shopifypioneer.com/drip-app/icons/drip.png"),
    "details" => env('channel_details', "Forward shopify data to your drip."),
    "is_channel_account_editable" => env('channel_is_channel_account_editable', true),
    "custom_app_option" => env('channel_custom_app_option', false),
    "slug" => env('channel_slug', "drip"),


];

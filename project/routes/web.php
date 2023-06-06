<?php

/*
 open ,non auth routes
*/
Route::get('/', function () {
    return view('errors.un_verrified_shopify_request');
});
Route::name('un_verrified_shopify_request')->get('un_verrified_shopify_request', 'ShopifyController@un_verrified_shopify_request');
Route::name('badLogin')->get('badLogin', 'ShopifyController@badLogin');
Route::get('one_signal_permission_window', function () {
    return view('web_push_notification.one_signal_permission_window');
})->name('one_signal_permission_window');
// app install links

Route::name('install')->get('install', 'ShopifyController@install_app');
Route::get('shopifycallback', 'ShopifyController@shopify_callback')->name('shopifycallback');
Route::name('shop.logout')->get('shop/logout', 'ShopifyController@logout');
Route::get('ms_excel_callback_single/', 'MicrosoftExcelManagementController@ms_excel_callback_single')
    ->name('ms_excel_callback_single');
Route::get('ms_excel_callback/', 'MicrosoftExcelManagementController@ms_excel_callback')
    ->name('ms_excel_callback');

// auth routes
Route::group(['middleware' => 'ShopAuth'], function () {
    // Nofication management
    Route::get('notifications/', 'NotificationsController@index')->name('notification.index');
    Route::get('notifications/get_all', 'NotificationsController@get_notifications')->name('notification.get_all');
    Route::get('notifications/marked_as_read/{id}', 'NotificationsController@marked_as_read')->name('notification.marked_as_read');
    Route::get('notifications/delete/{id}', 'NotificationsController@delete')->name('notification.delete');

    //channel management and access routes
    Route::get('channels/', 'ChannelsConfigController@channels')->name('channels');

    //get filtered channels
    Route::get('get_channels/', 'ChannelsConfigController@get_channels')->name('get_channels');

    Route::get('terms_and_conditions/', function () {
        return view('terms_and_conditions');
    })->name('terms_and_conditions');
    //user plans
    Route::get('pricing_plans/', 'PricingPlansController@plans_listing')
        ->name('plans_listing');
    Route::post('pricing_plans/update', 'PricingPlansController@update_pricing_plan')
        ->name('update_pricing_plan');

//registered webhooks screen routes
    Route::get('registered_webhooks/', 'RegisteredWebhooksController@index')->name('registered_webhooks');
    Route::get('registered_webhooks_ajax/', 'RegisteredWebhooksController@registered_webhooks_ajax')
        ->name('registered_webhooks_ajax');

    //faqs page
    Route::get('faqs', function () {
        return view('faqs');
    })->name('faqs');

    /*Logs and webhooks management routes */
    Route::get('store_logs/', 'WebhookManagementController@store_logs')
        ->name('store_logs');
    Route::post('delete_logs', 'WebhookManagementController@delete_logs')->name('delete_logs');
    Route::get('products/', 'WebhookManagementController@products')->name('products');
    Route::get('product', 'WebhookManagementController@product')->name('product');
    Route::post('product', 'WebhookManagementController@update_product')->name('update_product');
    Route::post('generate-images', 'WebhookManagementController@generate_images')->name('generate_images');
    Route::post('generate-text', 'WebhookManagementController@generate_text')->name('generate_text');
    Route::post('upload-images', 'WebhookManagementController@upload_images')->name('upload_images');
    Route::post('retry_failed_webhook/{id}', 'WebhookManagementController@retry_failed_webhook')->name('retry_failed_webhook');

    Route::delete('delete_registered_webhook/{id}', ['uses' => 'WebhookManagementController@delete_registered_webhook', 'as' => 'delete_registered_webhook']);
    Route::post('update_event_status/{id}', 'WebhookManagementController@update_event_status')
        ->name('update_event_status')
        ->middleware('CheckWebhooksLimit');
    Route::post('remove_channel_account/', 'WebhookManagementController@remove_channel_account')
        ->name('remove_channel_account');

//    store events config routes starts here
    Route::get('channel_config/{webhook_event_id}/{id?}', 'ChannelsConfigController@channel_config')->name('channel_config')
        ->middleware('CheckWebhooksLimit');
    Route::post('store_general_event_config/', 'WebhookManagementController@store_general_event_config')
        ->name('store_general_event_config')
        ->middleware('CheckWebhooksLimit');

    Route::post('update_general_event_config/{id}', 'WebhookManagementController@update_general_event_config')
        ->name('update_general_event_config')->middleware('CheckWebhooksLimit');
//    store events config routes ends here
    // billing routes
    Route::any('confirm_billing', 'ShopifyController@confirmBilling')->name('confirmBilling');
    Route::any('billing_page', 'ShopifyController@billing_page')->name('billing_page');
    Route::get('webhook_event_doc', 'Admin\DocsController@webhook_event_doc')->name('webhook_event_doc');
    Route::get('dashboard', 'WebhookManagementController@index')->name('dashboard');
//    Route::get('product', 'ProductController@product_list')->name('product');

    Route::get('automate', 'WebhookManagementController@webhookSettings')->name('automate');
    Route::get('favorites', 'WebhookManagementController@getFavorites')->name('getFavorites');

    // test webhooks routes
    Route::post('webhooks/test', 'TestWebhooksController@test_registered_webhook')
        ->name('test_registered_webhook');

});

Route::post('process_shopify_webhooks', 'WebhookReceiverController@process_shopify_webhooks')->name('process_shopify_webhooks');

Route::group(['middleware' => 'verifyShopify'], function () {
//receive orders route for slack notifications
    Route::post('appunistalled_webhook', 'ShopifyController@removeApp')->name('appunistalled_webhook');
    Route::any('customers/redact', 'WebhookReceiverController@customers_redact')->name('customers_redact');
    Route::any('shop/redact', 'WebhookReceiverController@shop_redact')->name('shop_redact');
    Route::any('customers/data_request', 'WebhookReceiverController@customers_data_request')->name('customers_data_request');
});

Route::get('testing', 'WebhookReceiverController@testing');
//Route::get('migration', 'MigrationController@do')
//    ->name('migration.do');

Route::fallback(function() {
    return view('errors.404');
});

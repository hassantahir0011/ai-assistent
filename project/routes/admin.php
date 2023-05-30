<?php

Route::group(['prefix' => 'backend', 'middleware' => ['web']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login')->name('admin.login.post');
    Route::get('/logout', 'Auth\LoginController@logout')->name('admin.logout');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.reset');;

    Route::group(['middleware' => ['auth']], function () {
        Route::get('docs/', 'Admin\DocsController@index')->name('admin.docs.index');
        Route::get('docs/settings', 'Admin\DocsController@settings')->name('admin.docs.settings');
        Route::post('docs/settings/save', 'Admin\DocsController@save_settings')->name('admin.docs.settings.save');
        Route::get('docs/edit/{id}', 'Admin\DocsController@edit')->name('admin.docs.edit');
        Route::get('docs/create', 'Admin\DocsController@create')->name('admin.docs.create');
        Route::post('docs/store', 'Admin\DocsController@store')->name('admin.docs.store');
        Route::post('docs/update/{id}', 'Admin\DocsController@update')->name('admin.docs.update');
        Route::delete('docs/delete/{id}', ['uses' => 'Admin\DocsController@delete', 'as' => 'admin.docs.delete']);
        //   stores listing
        Route::get('stores/', 'Admin\StoreDetailsController@index')->name('admin.stores.index');
        Route::get('stores/favoriteconnectorwithwebhookevent', 'Admin\StoreDetailsController@favoriteConnectorWithWebhookEvent')->name('admin.stores.favoriteconnectorwithwebhookevent');
        Route::post('stores/favoriteconnectorwithwebhookevent/create', 'Admin\StoreDetailsController@createFavoriteConnectorWithWebhookEvent')->name('admin.stores.favoriteconnectorwithwebhookevent.create');
        Route::post('stores/favoriteconnectorwithwebhookevent/update/{id}', 'Admin\StoreDetailsController@updateFavoriteConnectorWithWebhookEvent')->name('admin.stores.favoriteconnectorwithwebhookevent.update');
        Route::get('stores/favoriteconnectorwithwebhookevent/delete/{id}', 'Admin\StoreDetailsController@deleteFavoriteConnectorWithWebhookEvent')->name('admin.stores.favoriteconnectorwithwebhookevent.delete');
        Route::get('stores/ajax_listing', 'Admin\StoreDetailsController@stores_listing_ajax')
            ->name('stores_listing_ajax');
        Route::get('stores/view/{id}', 'Admin\StoreDetailsController@store_details')->name('admin.stores.view');
        Route::get('stores/notification/api_version', 'Admin\NotificationsController@notifyApiVersionUpdateView')->name('admin.stores.notify.api_version.update.view');
        Route::post('stores/notification/api_version/{send_email}', 'Admin\NotificationsController@notifyApiVersionUpdate')->name('admin.stores.notify.api_version.update');
        Route::get('stores/notify/api_version/get/webhook_events', 'Admin\NotificationsController@notifyApiVersionGetWebhookEvents')->name('admin.stores.notify.api_version.get.webhook_events');
        Route::get('stores/notify/api_version/get/webhook_topics', 'Admin\NotificationsController@notifyApiVersionGetWebhookTopics')->name('admin.stores.notify.api_version.get.webhook_topics');
//   stores job logs
        Route::get('stores/logs', 'Admin\StoreDetailsController@logs')->name('admin.stores.logs');
        Route::get('stores/logs/ajax_listing', 'Admin\StoreDetailsController@store_logs_listing_ajax')
            ->name('store_logs_listing_ajax');
        Route::get('stores/select2_ajax', 'Admin\StoreDetailsController@stores_select2_format')
            ->name('stores_select2_format');

    });

});

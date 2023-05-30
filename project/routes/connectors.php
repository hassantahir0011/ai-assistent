<?php

// auth routes
Route::group(['middleware' => 'web','ShopAuth'], function () {

    // drip routes
    Route::get('drip/auth/{id?}', 'DripEventsManagementController@drip_account_login')
        ->name('drip_account_login');
    Route::post('store_drip_account/', 'DripEventsManagementController@store_drip_account')
        ->name('store_drip_account');
    Route::get('get_drip_resources', 'DripEventsManagementController@get_drip_resources')
        ->name('get_drip_resources');
    Route::get('load_drip_fields_section', 'DripEventsManagementController@load_drip_fields_section')
        ->name('load_drip_fields_section');

});




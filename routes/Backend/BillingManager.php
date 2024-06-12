<?php

/*
 * CMS Person Management
 */
Route::group(['namespace' => 'BillingManager','middleware'=>['auth','practiceRole']], function () {
    Route::resource('BillingManager', 'BillingManagersController');
    Route::get('billing-manager', 'BillingManagersController@index')->name('billing-manager');
    Route::post('addBillingManager', 'BillingManagersController@addBillingManager')->name('addBillingManager');
    Route::get('deleteBillingmanager/{id}', 'BillingManagersController@deleteBillingmanager')->name('deleteBillingmanager');
    //For DataTables


});

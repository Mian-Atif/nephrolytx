<?php
/**
 * BillingManager
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'BillingManager'], function () {
        Route::resource('billingmanagers', 'BillingManagersController');
        //For Datatable
        Route::post('billingmanagers/get', 'BillingManagersTableController')->name('billingmanagers.get');

        Route::get('get-billing-modal/{id?}', 'BillingManagersController@getBillingMngrModal')->name('get-billing-modal');

    });
    
});
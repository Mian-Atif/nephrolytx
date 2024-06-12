<?php
/**
 * Provider
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Provider'], function () {
        Route::resource('providers', 'ProvidersController');
        //For Datatable
        Route::post('providers/get', 'ProvidersTableController')->name('providers.get');
    });
    
});
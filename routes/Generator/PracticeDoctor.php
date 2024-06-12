<?php
/**
 * PracticeDoctors
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PracticeDoctors'], function () {
        Route::resource('practicedoctors', 'PracticeDoctorsController');
        //For Datatable
        Route::post('practicedoctors/get', 'PracticeDoctorsTableController')->name('practicedoctors.get');

        Route::get('get-provider-modal/{id?}', 'PracticeDoctorsController@getProviderModal')->name('get-provider-modal');

    });

});
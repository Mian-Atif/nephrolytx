<?php
/**
 * PracticeLocations
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PracticeLocations'], function () {
        Route::resource('practicelocations', 'PracticeLocationsController');
        //For Datatable
        Route::post('practicelocations/get', 'PracticeLocationsTableController')->name('practicelocations.get');

        Route::get('get-location-modal/{id?}', 'PracticeLocationsController@getLocationModal')->name('get-location-modal');

    });
    
});
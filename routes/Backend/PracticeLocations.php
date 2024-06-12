<?php

/*
 * CMS Person Management
 */
Route::group(['namespace' => 'PracticeLocations'], function () {
    Route::resource('practicelocations', 'PracticeLocationsController');

    //For DataTables
    Route::post('saveLocations', 'PracticeLocationsController@saveLocations')->name('saveLocations');
    Route::post('updateLocation', 'PracticeLocationsController@updateLocation')->name('updateLocation');
    Route::get('editLocation/{id}', 'PracticeLocationsController@editLocation')->name('editLocation');
    Route::get('deleteLocation/{id}', 'PracticeLocationsController@deleteLocation')->name('deleteLocation');
});

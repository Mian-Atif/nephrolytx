<?php

/*
 * CMS Practices Management
 */
Route::group(['namespace' => 'Profile','middleware' => ['auth','role:Administrator']], function () {
    Route::get('profile', 'ProfilesController@index')->name('profile');
    Route::post('updateprofile', 'ProfilesController@updateprofile')->name('updateprofile');


});

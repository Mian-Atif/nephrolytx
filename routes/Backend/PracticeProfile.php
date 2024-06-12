<?php

/*
 * CMS Practices Management
 */

use Illuminate\Support\Facades\Auth;

Route::group(['namespace' => 'PracticeProfile','middleware'=>['auth','multipleRole']], function () {

    Route::get('practiceprofile', 'PracticeProfilesController@index')->name('practiceprofile');
    Route::post('updatepracticeprofile', 'PracticeProfilesController@updateprofile')->name('updatepracticeprofile');
    Route::post('updateprofilepassword', 'PracticeProfilesController@updatePassword')->name('updateprofilepassword');

});

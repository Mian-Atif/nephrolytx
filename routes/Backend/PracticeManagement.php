<?php

/*
 * CMS Practices Management
 */
Route::group(['namespace' => 'PracticeManagement','middleware'=>['auth','practiceRole']], function () {
    Route::get('practicemanagement', 'PracticeManagementsController@index')->name('practicemanagement');
    Route::post('updateuserpractice', 'PracticeManagementsController@updatePractice')->name('updateuserpractice');

 
});

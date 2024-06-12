<?php

/*
 * CMS Practices Management
 */
Route::group(['namespace' => 'PracticeUser'], function () {
    Route::get('practiceusers/{id}', 'PracticeusersController@index')->name('practiceusers');
    Route::get('addPracticeUser/{id}','PracticeusersController@create')->name('addPracticeUser');
    Route::post('savePracticeUser', 'PracticeusersController@savePracticeUser')->name('savePracticeUser');
    Route::get('get_doctor_by_location/{id}', 'PracticeusersController@getDoctorByLocation')->name('get_doctor_by_location');
    Route::get('pratice_user_status/{id}', 'PracticeusersController@updateStatus')->name('pratice_user_status');
    //For DataTables
});

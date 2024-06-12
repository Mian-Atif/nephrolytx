<?php

/*
 * CMS Practices Management
 */
Route::group(['namespace' => 'PracticeUserManagement' , 'middleware'=>['auth','practiceRole']], function () {
    Route::get('practiceusersmanagement', 'PracticeUserManagementsController@index')->name('practiceusersmanagement');
//    Route::get('addPracticeUser','PracticeUserManagementsController@create')->name('addPracticeUser');
      Route::get('practiceuseradd','PracticeUserManagementsController@create')->name('practiceuseradd');
      Route::post('savepracticeusers', 'PracticeUserManagementsController@savePracticeUser')->name('savepracticeusers');
      Route::get('get_practice_doctor_by_location/{id}', 'PracticeUserManagementsController@getDoctorByLocation')->name('get_practice_doctor_by_location');
      Route::get('change_user_status/{id}', 'PracticeUserManagementsController@userStatus')->name('change_user_status');

      //    //For DataTables
});

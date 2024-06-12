<?php

/*
 * CMS Person Management
 */
Route::group(['namespace' => 'PracticeDoctors'], function () {
    Route::resource('practicedoctors', 'PracticeDoctorsController');

    //For DataTables
    Route::post('saveDoctors', 'PracticeDoctorsController@saveDoctors')->name('saveDoctors');
    Route::post('updateDoctors', 'PracticeDoctorsController@updateDoctors')->name('updateDoctors');
    Route::get('editDoctor/{id}', 'PracticeDoctorsController@editDoctor')->name('editDoctor');
    Route::get('deleteDoctor/{id}', 'PracticeDoctorsController@deleteDoctor')->name('deleteDoctor');
});

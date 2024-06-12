<?php

/*
 * CMS Practices Management
 */
Route::group(['namespace' => 'Practice'], function () {
    Route::resource('practices', 'PracticesController');
    
    Route::get('/ajaxsync', function () {
        return 'Hello world!';
    });
    //For DataTables
    Route::post('practices/get', 'PracticesTableController')->name('practices.get');
    Route::post('practice-save', 'PracticesController@savePractice')->name('practice-save');
    Route::post('saveBillingManager', 'PracticesController@saveBillingManager')->name('saveBillingManager');
    Route::get('practice_user_management/{id}', 'PracticesController@userManagement')->name('userManagement');
    Route::get('deleteBillingUser/{id}', 'PracticesController@deleteBillingUser')->name('deleteBillingUser');
    Route::get('deleteDoctorUser/{id}', 'PracticesController@deleteDoctorUser')->name('deleteDoctorUser');
});

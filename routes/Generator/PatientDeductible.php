<?php
/**
 * Routes for : PatientDeductible
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {

    Route::group(['namespace' => 'PatientDeductible'], function () {
        Route::resource('patient-deductibles', 'PatientDeductiblesController');
        //For Datatable
        Route::post('patientdeductibles/get', 'PatientDeductiblesTableController')->name('patientdeductibles.get');
    });

});
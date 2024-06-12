<?php
/**
 * Routes for : PatientPayments
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {

    Route::group(['namespace' => 'PatientPayments'], function () {
        Route::resource('patient-payments', 'PatientPaymentsController');

        //For Datatable
        Route::post('patientpayments/get', 'PatientPaymentsTableController')->name('patientpayments.get');
    });

});
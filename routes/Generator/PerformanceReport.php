<?php
/**
 * Routes for : PerformanceReport
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {

    Route::group(['namespace' => 'PerformanceReport'], function () {
        Route::resource('performance-reports', 'PerformanceReportsController');
        //For Datatable
        Route::post('performancereports/get', 'PerformanceReportsTableController')->name('performancereports.get');
    });

});
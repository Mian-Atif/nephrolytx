<?php
/**
 * UploadReportsData
 *
 */


Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.' ], function () {
    
    Route::group( ['namespace' => 'UploadReportsData','middleware' => ['auth','userPracticeRole']], function () {
        Route::resource('upload-reports-data', 'UploadReportsDataController');
        Route::post('upload-reports-data/single-load', 'UploadReportsDataController@loadSingle')->name('upload-reports-data.add');
        //For Datatable
        Route::post('upload-reports-data/get', 'UploadReportsDataTableController')->name('upload-reports-data.get');
    });
    
});
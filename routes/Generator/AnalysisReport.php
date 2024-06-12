<?php
/**
 * Routes for : AnalysisReport
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'AnalysisReport'], function () {
	    Route::Resource('analysis-of-major-services','AnalysisReportsController');

	    //For Datatable
	    Route::post('analysisreports/get', 'AnalysisReportsTableController')->name('analysisreports.get');
	});
	
});
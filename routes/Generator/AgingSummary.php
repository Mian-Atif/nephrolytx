<?php
/**
 * Routes for : AgingSummary
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'AgingSummary'], function () {
        Route::resource('aging-summaries', 'AgingSummariesController');
        //For Datatable
	    Route::post('agingsummaries/get', 'AgingSummariesTableController')->name('agingsummaries.get');
	});
	
});
<?php
/**
 * Routes for : LatePatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'LatePatientBalance'], function () {
	    Route::resource('analysis-by-service-type', 'LatePatientBalancesController');

	    //For Datatable
	    Route::post('latepatientbalances/get', 'LatePatientBalancesTableController')->name('latepatientbalances.get');
	});
	
});
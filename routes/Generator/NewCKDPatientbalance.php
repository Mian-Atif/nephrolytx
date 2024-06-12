<?php
/**
 * Routes for : NewCKDPatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'NewCKDPatientBalance'], function () {
	    Route::resource('analysis-by-service-location','NewCKDPatientbalancesController');

        //For Datatable
	    Route::post('newckdpatientbalances/get', 'NewCKDPatientbalancesTableController')->name('newckdpatientbalances.get');
	});
	
});
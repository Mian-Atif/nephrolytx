<?php
/**
 * Routes for : TotalActivePatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'TotalActivePatientBalance'], function () {
//	    Route::get('month-wise-patients', 'TotalActivePatientBalancesController@index')->name('month-wise-patients.index');
	    Route::resource('charge-payment-analysis','TotalActivePatientBalancesController');
	    
	    
	    //For Datatablejs/dataTable.js
	    Route::post('totalactivepatientbalances/get', 'TotalActivePatientBalancesTableController')->name('totalactivepatientbalances.get');
	});
	
});
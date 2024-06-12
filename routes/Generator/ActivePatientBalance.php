<?php
/**
 * Routes for : ActivePatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'ActivePatientBalance'], function () {
	    Route::get('active-patient-balances', 'ActivePatientBalancesController@index')->name('activepatientbalances.index');
	    
	    
	    
	    //For Datatable
	    Route::post('activepatientbalances/get', 'ActivePatientBalancesTableController')->name('activepatientbalances.get');
	});
	
});
<?php
/**
 * Routes for : CKDPatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'CkdPatientBalance'], function () {


	    Route::get('ckd-patient-balances', 'CkdPatientBalancesController@index')->name('ckd-patient-balances.index');
	    
	    
	    
	    //For Datatable
	    Route::post('ckdpatientbalances/get', 'CkdPatientBalancesTableController')->name('ckdpatientbalances.get');
	});
	
});
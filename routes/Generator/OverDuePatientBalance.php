<?php
/**
 * Routes for : OverduePatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'OverduePatientBalance'], function () {
	    Route::get('aging-summary', 'OverDuePatientBalancesController@index')->name('aging-summary.index');
	    
	    
	    
	    //For Datatable
	    Route::post('overduepatientbalances/get', 'OverDuePatientBalancesTableController')->name('overduepatientbalances.get');
	});
	
});
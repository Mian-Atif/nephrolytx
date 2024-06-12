<?php
/**
 * Routes for : ChequeReconciliationDetail
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'ChequeReconciliationDetail'], function () {
        Route::resource('cheque-reconciliation-details', 'ChequeReconciliationDetailsController');
	    //For Datatable
//	    Route::post('chequereconciliationdetails/get', 'ChequeReconciliationDetailsTableController')->name('chequereconciliationdetails.get');
	});
	
});
<?php
/**
 * Routes for : TransactionAnalysis
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'TransactionAnalysis'], function () {
        Route::resource('transaction-analysis', 'TransactionAnalysisController');
        //For Datatable
	    Route::post('transactionanalysis/get', 'TransactionAnalysisTableController')->name('transactionanalysis.get');
	});
	
});
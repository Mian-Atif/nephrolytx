<?php
/**
 * Routes for : ESRDPatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'EsrdPatientBalance'], function () {
//	    Route::get('esrd-patient-balances', 'ESRDPatientBalancesController@index')->name('esrd-patient-balances.index');
        Route::resource('collection-analysis', 'ESRDPatientBalancesController');


        //For Datatable
	    Route::post('esrdpatientbalances/get', 'ESRDPatientBalancesTableController')->name('esrdpatientbalances.get');
	});
	
});
<?php
/**
 * Routes for : ESRDPatientBalance
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'ESRDPatientName'], function () {
	    Route::get('esrd-patients', 'ESRDPatientsController@index')->name('esrdpatients.index');
	    
	    
	    
	    //For Datatable
	    Route::post('esrdpatients/get', 'ESRDPatientsTableController')->name('esrdpatients.get');
	});
	
});
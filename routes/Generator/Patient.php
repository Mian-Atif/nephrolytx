<?php
/**
 * Routes for : Patient
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'Patient'], function () {
	    Route::get('patients', 'PatientsController@index')->name('patients.index');
	    
	    
	    
	    //For Datatable
	    Route::post('patients/get', 'PatientsTableController')->name('patients.get');
	});
	
});
<?php
/**
 * Routes for : Revenue
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
	
	Route::group( ['namespace' => 'Revenue'], function () {
	    Route::get('patients-list/{type}', 'RevenuesController@index')->name('patients-list.index');
	    Route::get('patient-detail/{id}', 'RevenuesController@patientDetail')->name('patient-detail');
	    
	    
	    
	    //For Datatable
	    Route::post('revenues/get', 'RevenuesTableController')->name('revenues.get');
	});
	
});
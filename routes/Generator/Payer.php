<?php
/**
 * Routes for : Payer
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'Payer'], function () {
	    Route::get('payers', 'PayersController@index')->name('payers.index');
	    
	    
	    
	    //For Datatable
	    Route::post('payers/get', 'PayersTableController')->name('payers.get');
	});
	
});
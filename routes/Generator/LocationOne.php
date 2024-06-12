<?php
/**
 * Routes for : LocationOne
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'LocationOne'], function () {
	    Route::get('location-one', 'LocationOnesController@index')->name('location-one.index');
	    
	    
	    
	    //For Datatable
	    Route::post('locationones/get', 'LocationOnesTableController')->name('locationones.get');
	});
	
});
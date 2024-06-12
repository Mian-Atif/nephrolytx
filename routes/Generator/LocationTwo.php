<?php
/**
 * Routes for : LocationTwo
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'LocationTwo'], function () {
	    Route::get('location-two', 'LocationTwosController@index')->name('location-two.index');
	    
	    
	    
	    //For Datatable
	    Route::post('locationtwos/get', 'LocationTwosTableController')->name('locationtwos.get');
	});
	
});
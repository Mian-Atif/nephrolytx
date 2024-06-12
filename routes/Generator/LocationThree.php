<?php
/**
 * Routes for : LocationThree
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'LocationThree'], function () {
	    Route::get('location-three', 'LocationThreesController@index')->name('location-three.index');
	    
	    
	    
	    //For Datatable
	    Route::post('locationthrees/get', 'LocationThreesTableController')->name('locationthrees.get');
	});
	
});
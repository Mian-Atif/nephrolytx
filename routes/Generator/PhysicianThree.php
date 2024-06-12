<?php
/**
 * Routes for : PhysicianThree
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'PhysicianThree'], function () {
	    Route::get('physician-three', 'PhysicianThreesController@index')->name('physician-three.index');
	    
	    
	    
	    //For Datatable
	    Route::post('physicianthrees/get', 'PhysicianThreesTableController')->name('physicianthrees.get');
	});
	
});
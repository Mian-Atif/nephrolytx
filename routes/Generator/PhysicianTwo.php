<?php
/**
 * Routes for : PhysicianTwo
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'PhysicianTwo'], function () {
	    Route::get('physician-two', 'PhysicianTwosController@index')->name('physician-two.index');
	    
	    
	    
	    //For Datatable
	    Route::post('physiciantwos/get', 'PhysicianTwosTableController')->name('physiciantwos.get');
	});
	
});
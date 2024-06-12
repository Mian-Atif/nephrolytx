<?php
/**
 * Routes for : Physician1
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'Physician1'], function () {
	    Route::get('physician-one', 'PhysicianOnesController@index')->name('physician-one.index');
	    
	    
	    
	    //For Datatable
	    Route::post('physicianones/get', 'PhysicianOnesTableController')->name('physicianones.get');
	});
	
});
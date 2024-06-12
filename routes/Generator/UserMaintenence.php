<?php
/**
 * Routes for : UserMaintenence
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'UserMaintenence'], function () {
	    Route::get('user-maintenences', 'UserMaintenencesController@index')->name('user-maintenences.index');
	    
	    
	    
	    //For Datatable
	    Route::post('usermaintenences/get', 'UserMaintenencesTableController')->name('usermaintenences.get');
	});
	
});
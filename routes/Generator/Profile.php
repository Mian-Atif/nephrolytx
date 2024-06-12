<?php
/**
 * Routes for : Profile
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'Profile','middleware'=>['auth','role:Administrator']], function () {
	    Route::get('profiles', 'ProfilesController@index')->name('profiles.index');
	    
	    
	    
	    //For Datatable
	    Route::post('profiles/get', 'ProfilesTableController')->name('profiles.get');
	});
	
});
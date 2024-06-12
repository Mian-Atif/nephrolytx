<?php
/**
 * Routes for : Prayers
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'Prayer'], function () {
	    Route::get('prayers', 'PrayersController@index')->name('prayers.index');
	    
	    
	    
	    //For Datatable
	    Route::post('prayers/get', 'PrayersTableController')->name('prayers.get');
	});
	
});
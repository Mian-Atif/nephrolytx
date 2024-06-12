<?php
/**
 * Routes for : Procedure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
	
	Route::group( ['namespace' => 'Procedure'], function () {
	    Route::get('procedures', 'ProceduresController@index')->name('procedures.index');
	    
	    
	    
	    //For Datatable
	    Route::post('procedures/get', 'ProceduresTableController')->name('procedures.get');
	});
	
});
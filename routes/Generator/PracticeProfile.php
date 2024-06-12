<?php
/**
 * Routes for : PracticeProfile
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin','multipleRole']], function () {
	
	Route::group( ['namespace' => 'PracticeProfile'], function () {
	    Route::get('practiceprofiles', 'PracticeProfilesController@index')->name('practiceprofiles.index');
	    
	    
	    
	    //For Datatable
	    Route::post('practiceprofiles/get', 'PracticeProfilesTableController')->name('practiceprofiles.get');
	});
	
});
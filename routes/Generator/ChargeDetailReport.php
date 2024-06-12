<?php
/**
 * Routes for : ChargeDetailReport
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'multipleRole'], function () {
	
	Route::group( ['namespace' => 'ChargeDetailReport'], function () {
        Route::resource('charge-detail-reports', 'ChargeDetailReportsController');
	    //For Datatable
	    Route::post('chargedetailreports/get', 'ChargeDetailReportsTableController')->name('chargedetailreports.get');
	});
	
});
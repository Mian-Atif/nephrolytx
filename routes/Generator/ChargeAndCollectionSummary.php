<?php
/**
 * Routes for : ChargeAndCollectionSummary
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {

	Route::group( ['namespace' => 'ChargeAndCollectionSummary'], function () {
        Route::resource('charge-and-collection-summaries', 'ChargeAndCollectionSummariesController');
        //For Datatable
	    Route::post('chargeandcollectionsummaries/get', 'ChargeAndCollectionSummariesTableController')->name('chargeandcollectionsummaries.get');
	});
	
});
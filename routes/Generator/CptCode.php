<?php
/**
 * Routes for : CptCode
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','userPracticeRole']], function () {
	
	Route::group( ['namespace' => 'CptCode'], function () {
	    Route::get('cptcodes', 'CptCodesController@index')->name('cptcodes.index');
        Route::get('cptcodeandrvu', 'CptCodeRuvController@index')->name('cptcodeandrvu.index');

        Route::get('get-cptcodePrice-modal', 'CptCodesController@getcptcodePriceModal')->name('get-cptcodePrice-modal');
	    Route::get('cptcodes/create', 'CptCodesController@create')->name('cptcodes.create');
//	    Route::get('cptcodervu/create', 'CptCodeRuvController@create')->name('cptcodervu.create');
	    Route::get('cptcodes/{amount?}/{id?}', 'CptCodesController@getCptAmount')->name('cptcodes.amount');
	    Route::resource('cptcodes', 'CptCodesController');
	    Route::resource('cptcodervu', 'CptCodeRuvController');
	    Route::post('cptcodes-save', 'CptCodesController@save')->name('cptcodes.save');
	    Route::post('cpt-default-store', 'CptCodesController@cptDefaultStore')->name('cpt-default-store');
	    Route::get('cptcodes-default', 'CptCodesController@cptCodeDefault')->name('cptcodes-default');
        Route::get('get-cptcode-default-modal', 'CptCodesController@getcptcodeDefaultModal')->name('get-cptcode-deafult-modal');

        Route::post('cptcodes-save', 'CptCodesController@save')->name('cptcodes.save');
        //For Datatable
        Route::post('cptCodeFilter', 'CptCodesController@cptCodeFilter')->name('cptCodeFilter');

//        Route::get('cptCodeFilter/{id?}', 'CptCodesController@cptCodeFilter')->name('cptCodeFilter');
	});
	
});
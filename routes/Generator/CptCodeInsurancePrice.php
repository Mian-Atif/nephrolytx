<?php
/**
 * CptCodeInsurancePrice
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','userPracticeRole']], function () {
    
    Route::group( ['namespace' => 'CptCodeInsurancePrices'], function () {
        Route::resource('cptcode-insurance-prices', 'CptCodeInsurancePricesController');
        //For Datatable
            Route::get('get-commit-modal/{id?}','CptCodeInsurancePricesController@getCommitModal');
            Route::get('get-cptcode-insurance-modal','CptCodeInsurancePricesController@getcptcodeInsuranceModal');

        Route::post('cptcodeinsuranceprices/get', 'CptCodeInsurancePricesTableController')->name('cptcodeinsuranceprices.get');
        Route::get('cptCodePayerPractice/{id?}', 'CptCodeInsurancePricesController@cptCodePayerPractice')->name('cptCodePayerPractice');
        Route::post('cptCodePayerFilter', 'CptCodeInsurancePricesController@cptCodePayerFilter')->name('cptCodePayerFilter');

    });
    
});
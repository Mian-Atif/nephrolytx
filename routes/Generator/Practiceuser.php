<?php
/**
 * PracticeUser
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PracticeUser'], function () {
        Route::resource('practiceusers', 'PracticeusersController');
        //For Datatable
        Route::post('practiceusers/get', 'PracticeusersTableController')->name('practiceusers.get');
    });
    
});
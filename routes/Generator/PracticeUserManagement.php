<?php
/**
 * PracticeUserManagement
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PracticeUserManagement','middleware'=>['auth','practiceRole']], function () {
        Route::resource('practiceusermanagements', 'PracticeUserManagementsController');
        //For Datatable
        Route::post('practiceusermanagements/get', 'PracticeUserManagementsTableController')->name('practiceusermanagements.get');
    });
    
});
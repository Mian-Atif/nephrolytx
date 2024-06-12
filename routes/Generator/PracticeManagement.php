<?php
/**
 * PracticeManagement
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PracticeManagement'], function () {
        Route::resource('practicemanagements', 'PracticeManagementsController');
        //For Datatable
        Route::post('practicemanagements/get', 'PracticeManagementsTableController')->name('practicemanagements.get');
    });
    
});
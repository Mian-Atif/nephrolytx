<?php

/*
 * CMS Person Management
 */
Route::group(['namespace' => 'Person'], function () {
    Route::resource('person', 'PersonController');

    //For DataTables
    Route::post('person/get', 'PersonTableController')->name('person.get');
});

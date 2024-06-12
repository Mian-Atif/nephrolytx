<?php

/**
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
use Illuminate\Support\Facades\Route;



Route::get('verify/resend', 'TwoFactorController@resend')->name('verify.resend');
Route::post('change-password', 'Frontend\Auth\LoginController@changePassword')->name('changePassword');
Route::get('/clear-cache', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!" . env('DB_DATABASE');
});
Route::group(['middleware' => ['admin']], function () {
    Route::resource('verify', 'TwoFactorController')->only(['index', 'store']);
    Route::get('password/expired', 'Backend\Access\User\ExpiredPasswordController@index')
        ->name('password.expired');
    Route::post('password/post_expired', 'Backend\Access\User\ExpiredPasswordController@postExpired')
        ->name('password.post_expired');
});

Route::get('admin/config.app', 'Frontend\FrontendController@createConfigApp');
Route::post('registerAdminUser', 'Frontend\FrontendController@registerAdminUserOnLocal')->name('registerAdminUser');
Route::get('lang/{lang}', 'LanguageController@swap');
Route::get('verify-email/{id}', 'Frontend\FrontendController@verifyEmail')->name('verifyEmail');
Route::post('/verify-password', 'Frontend\FrontendController@verifyPassword')->name('verify-password');

/* ----------------------------------------------------------------------- */

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__ . '/Frontend/');
});

Route::resource('password-expired', 'Frontend\Auth\ExpiredPasswordController');


/* ----------------------------------------------------------------------- */
/*
 * Backend Routes
 * Namespaces indicate folder structure
 */


Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth','multipleRole']], function () {
    Route::resource('ar-analysis-by-financial-class', 'AnalysisInsurance\AnalysisInsurancesController');
    Route::resource('verify', 'TwoFactorController')->only(['index', 'store']);
    Route::resource('ar-analysis-by-provider', 'AnalysisProvider\AnalysisProvidersController');
    Route::resource('ar-analysis-by-location', 'AnalysisLocation\AnalysisLocationsController');
    Route::resource('productivity-analysis', 'ProductivityAnalysis\ProductivityAnalysisController');
    Route::resource('procedure-analysis', 'ProcedureAnalysis\ProcedureAnalysisController');

    /*    Route::get('ar-analysis-by-provider', function (){
            return view('backend.financialReports.AR-analysis-by-provider');
        });
        Route::get('ar-analysis-by-location', function (){
            return view('backend.financialReports.AR-analysis-by-location');
        });
        Route::get('productivity-analysis', function (){
            return view('backend.financialReports.productivity-analysis');
        });*/
});
Route::get('/flush_route', function () {
    flushRoute();
    return redirect('/login')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.pass_change'));
})->name('flush_route');

Route::get('/flash_route', function () {
    flashRoute();
    return redirect('/login')->withFlashDanger(trans('exceptions.frontend.auth.password.old_password'));
})->name('flash_route');

Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin', 'twofactor']], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    includeRouteFiles(__DIR__ . '/Backend/');
    Route::group(['middleware' => 'auth','multipleRole'], function () {

        Route::get('aging-summary', function () {
            return view('backend.financialReports.aging-summary');
        });
    });
    /*  Route::get('ar-analysis-by-location', function (){
          return view('backend.financialReports.AR-analysis-by-location');
      });
      Route::get('deductibles-report', function (){
          return view('backend.financialReports.deductibles-report');
      });
      Route::get('patients-payment-report', function (){
          return view('backend.financialReports.patients-payment-report');
      });
      Route::get('performance-report', function (){
          return view('backend.financialReports.performance-report');
      });
      Route::get('procedure-analysis', function (){
          return view('backend.financialReports.procedure-analysis');
      });
      Route::get('productivity-analysis', function (){
          return view('backend.financialReports.productivity-analysis');
      });
      Route::get('transaction-analysis', function (){
          return view('backend.financialReports.transaction-analysis');
      });
      Route::get('charges-collection-summary', function (){
          return view('backend.financialReports.charges-collection-summary');
      });
      Route::get('checks-reconciliation-report', function (){
          return view('backend.financialReports.checks-reconciliation-report');
      });*/
//    Route::resource('practices', 'Practice\PracticesController');
//    Route::post('practices/get', 'PracticesController@getData')->name('practices.get');
});


/*
* Routes From Module Generator
*/
includeRouteFiles(__DIR__ . '/Generator/');
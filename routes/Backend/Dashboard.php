<?php


/**
 * All route names are prefixed with 'admin.'.
 */
Route::group(['middleware' => ['auth','role:Administrator']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    
});
Route::group(['middleware'=>['auth','multipleRole']], function () {

    

    Route::get('practice-dashboard', 'PracticeDashboardController@index')->name('practiceDashboard');
    Route::get('home', 'HomeController@home')->name('home');
    Route::post('form-submit', 'HomeController@feedBackSubmit')->name('formsubmit');
    Route::get('active-patient-orm', 'HomeController@test_query_time')->name('test_query_time');
    Route::get('active-patient-mysql', 'HomeController@test_query_time')->name('test_query_time_mysql');
    Route::get('revenue-fte-orm', 'HomeController@revenue_per_fte_month_orm')->name('revenue_per_fte_month_orm');
    Route::get('revenue-fte-mysql', 'HomeController@revenue_per_fte_month_mysql')->name('revenue_per_fte_month_mysql');
    
    Route::get('quick-tools/quick-summary/esrdpatients', 'Esrdpatients@index')->name('esrdpatients');
    Route::get('quick-tools/quick-summary/late-stage-ckd-patient', 'LateStageCkdPatient@index')->name('late-stage-ckd-patient');
    Route::get('quick-tools/quick-summary/practice-revenue', 'PracticeRevenue@index')->name('practice-revenue');
    Route::get('quick-tools/quick-summary/productivity-others', 'ProductivityOthers@index')->name('productivity-others');
    Route::get('quick-tools/optimal-starts/summary', 'SummaryOptimalStarts@index')->name('summary-optimal-starts');
    Route::get('quick-tools/optimal-starts/drivers', 'DriversOptimalStarts@index')->name('drivers-optimal-starts');
    Route::get('quick-tools/optimal-starts/home-dialysis', 'HomeDialysisOptimalStarts@index')->name('home-dialysis-optimal-starts');
    Route::get('quick-tools/optimal-starts/new-start-roster', 'NewStartRoaster@index')->name('new-start-roaster');
    Route::get('quick-tools/optimal-starts/late-stage-roster', 'LateStageRoaster@index')->name('late-stage-roaster');
    Route::get('quick-tools/revenue-cycle/summary', 'SummaryRevenueCycle@index')->name('summary-revenue-cycle');
    Route::get('quick-tools/revenue-cycle/office-services', 'OfficeServices@index')->name('office-services');
    Route::get('quick-tools/revenue-cycle/mcp-services', 'MCPServices@index')->name('mcp-services');
    Route::get('quick-tools/revenue-cycle/rate-volume-analysis', 'RateVolumeAnalysis@index')->name('rate-volume-analysis');
    Route::get('quick-tools/revenue-cycle/hospital-services', 'HomeDialysisRevenueCycle@index')->name('hospital-services-revenue-cycle');
    
    Route::get('quick-tools/quick-summary', 'QuickSummaryQuicktools@index')->name('quicksummary-quicktools');
    Route::get('quick-tools/optimal-starts', 'OptimalStartsQuickTools@index')->name('optimal-starts-quick-tools');
    Route::get('quick-tools/revenue-cycle', 'RevenueCycleQuicktools@index')->name('revenue-cycle-quicktools');
    
    Route::get('patient-dashboard/roster/pt-roster-list', 'PtRosterList@index')->name('pt-roster-list');
    Route::get('patient-dashboard/roster/pt-follow-up-roster', 'PtRosterList@followUpRoaster')->name('pt-follow-up-roster');
    Route::get('patient-dashboard/patient-analytics/no-of-pts-patientAnalysis', 'NoOfPtsPatientAnalysis@index')->name('no-of-pts-patientAnalysis');
    Route::get('patient-dashboard/patient-analytics/pt-analysis-patient-analytics', 'PtAnalysisPatientAnalytics@index')->name('pt-analysis-patient-analytics');
    Route::get('patient-dashboard/patient-analytics/ckd-pt-comparision', 'CKDPtComparision@index')->name('ckd-pt-comparision');
    Route::get('patient-dashboard/patient-analytics/ckd-pt-bmi', 'CKDPtBmi@index')->name('ckd-pt-bmi');
    Route::get('patient-dashboard/patient-analytics/rate-volume-analysis-pa', 'RateVolumeAnalysisPA@index')->name('rate-volume-analysis-pa');
    Route::get('patient-dashboard/patients-abnormal/pts-with-albumin-under', 'PtsWithAlbuminUnder@index')->name('pts-with-albumin-under');
    Route::get('patient-dashboard/patients-abnormal/pts-with-gf-under', 'PtsWithGFRunder@index')->name('pts-with-gf-under');
    Route::get('practice-dashboard/year-to-date', 'PracticeDashboardController@yearToDate')->name('yearToDate');
    Route::get('patient-analysis', 'PracticeDashboardController@patientAnalysis')->name('patient-analysis');
    Route::post('patient-analysis-search', 'PracticeDashboardController@patientAnalysisSearch')->name('patient-analysis-search');
    Route::post('patient-analysis-to-from-date', 'PracticeDashboardController@patientAnalysisToFromDate')->name('patient-analysis-to-from-date');
    Route::post('search', 'PracticeDashboardController@search')->name('search');
    Route::get('open-cases', 'PracticeDashboardController@projectedCollection')->name('projectedCollections');
    Route::get('under-paid-cases', 'PracticeDashboardController@underPaidCases')->name('underPaidCases');
    Route::get('monthly-patient-analysis', 'PracticeDashboardController@monthlyPatientAnalysis')->name('monthlyPatientAnalysis');

    // Clinical Dashboard
    Route::get('clinical-dashboard', 'ClinicalDashboardController@index')->name('clinical-dashboard');
    Route::get('interval-detail', 'ClinicalDashboardController@intervalDetail')->name('interval-detail');
    Route::post('clinical-filter', 'ClinicalDashboardController@ajaxLoad')->name('clinical-filter');
    Route::post('interval-filter', 'ClinicalDashboardController@intervalFilter')->name('interval-filter');
    Route::post('clinical-search', 'ClinicalDashboardController@search')->name('clinical-search');
   
});

/*Route::get('practice-dashboard',function (){
    return view('backend.practice-dashboard');
})->name('practiceDashboard');*/
Route::post('get-permission', 'DashboardController@getPermissionByRole')->name('get.permission');

/*
 * Edit Profile
*/
Route::get('profile/edit', 'DashboardController@editProfile')->name('profile.edit');
Route::patch('profile/update', 'DashboardController@updateProfile')
    ->name('profile.update');

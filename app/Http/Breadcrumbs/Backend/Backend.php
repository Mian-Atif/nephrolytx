<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(__('navs.backend.dashboard'), route('admin.dashboard'));
});

require __DIR__.'/Search.php';
require __DIR__.'/Access/User.php';
require __DIR__.'/Access/Role.php';
require __DIR__.'/Access/Permission.php';
require __DIR__.'/Page.php';
require __DIR__.'/Setting.php';
require __DIR__.'/Blog_Category.php';
require __DIR__.'/Blog_Tag.php';
require __DIR__.'/Blog_Management.php';
require __DIR__.'/Faqs.php';
require __DIR__.'/Menu.php';
require __DIR__.'/LogViewer.php';

require __DIR__.'/Patient.php';
require __DIR__.'/ActivePatientBalance.php';
require __DIR__.'/ESRDPatient.php';
require __DIR__.'/Practice.php';
require __DIR__.'/Provider.php';
require __DIR__.'/TotalActivePatientBalance.php';
require __DIR__.'/ESRDPatientBalance.php';
require __DIR__.'/CkdPatientBalance.php';
require __DIR__.'/LatePatientBalance.php';
require __DIR__.'/AnalysisReport.php';
require __DIR__.'/NewCKDPatientbalance.php';
require __DIR__.'/OverDuePatientBalance.php';
require __DIR__.'/Revenue.php';
require __DIR__.'/PhysicianOne.php';
require __DIR__.'/PhysicianTwo.php';
require __DIR__.'/PhysicianThree.php';
require __DIR__.'/Procedure.php';
require __DIR__.'/Prayer.php';
require __DIR__.'/UserMaintenence.php';
require __DIR__.'/LocationOne.php';
require __DIR__.'/LocationTwo.php';
require __DIR__.'/LocationThree.php';
require __DIR__.'/UploadReportsDatum.php';
require __DIR__.'/PracticeLocation.php';
require __DIR__.'/PracticeDoctor.php';
require __DIR__.'/BillingManager.php';
require __DIR__.'/Practiceuser.php';
require __DIR__.'/PracticeUserManagement.php';
require __DIR__.'/PracticeManagement.php';
require __DIR__.'/PracticeProfile.php';
require __DIR__.'/ChargeDetailReport.php';
require __DIR__.'/ChargeAndCollectionSummary.php';
require __DIR__.'/ChequeReconciliationDetail.php';
require __DIR__.'/PatientPayment.php';
require __DIR__.'/PatientDeductible.php';
require __DIR__.'/TransactionAnalysi.php';
require __DIR__.'/PerformanceReport.php';
require __DIR__.'/Profile.php';
require __DIR__.'/AgingSummary.php';

require __DIR__.'/CptCode.php';
require __DIR__.'/CptCodeInsurancePrice.php';
require __DIR__.'/Payer.php';
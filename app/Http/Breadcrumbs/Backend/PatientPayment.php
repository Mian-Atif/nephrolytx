<?php

Breadcrumbs::register('admin.patientpayments.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.patientpayments.management'), route('admin.patientpayments.index'));
});

Breadcrumbs::register('admin.patientpayments.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.patientpayments.index');
    $breadcrumbs->push(trans('menus.backend.patientpayments.create'), route('admin.patientpayments.create'));
});

Breadcrumbs::register('admin.patientpayments.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.patientpayments.index');
    $breadcrumbs->push(trans('menus.backend.patientpayments.edit'), route('admin.patientpayments.edit', $id));
});

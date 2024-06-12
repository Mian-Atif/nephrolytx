<?php

Breadcrumbs::register('admin.patientdeductibles.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.patientdeductibles.management'), route('admin.patientdeductibles.index'));
});

Breadcrumbs::register('admin.patientdeductibles.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.patientdeductibles.index');
    $breadcrumbs->push(trans('menus.backend.patientdeductibles.create'), route('admin.patientdeductibles.create'));
});

Breadcrumbs::register('admin.patientdeductibles.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.patientdeductibles.index');
    $breadcrumbs->push(trans('menus.backend.patientdeductibles.edit'), route('admin.patientdeductibles.edit', $id));
});

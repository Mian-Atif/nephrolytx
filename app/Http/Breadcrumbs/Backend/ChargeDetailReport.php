<?php

Breadcrumbs::register('admin.chargedetailreports.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.chargedetailreports.management'), route('admin.chargedetailreports.index'));
});

Breadcrumbs::register('admin.chargedetailreports.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.chargedetailreports.index');
    $breadcrumbs->push(trans('menus.backend.chargedetailreports.create'), route('admin.chargedetailreports.create'));
});

Breadcrumbs::register('admin.chargedetailreports.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.chargedetailreports.index');
    $breadcrumbs->push(trans('menus.backend.chargedetailreports.edit'), route('admin.chargedetailreports.edit', $id));
});

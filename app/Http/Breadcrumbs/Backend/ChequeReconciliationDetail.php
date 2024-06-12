<?php

Breadcrumbs::register('admin.chequereconciliationdetails.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.chequereconciliationdetails.management'), route('admin.chequereconciliationdetails.index'));
});

Breadcrumbs::register('admin.chequereconciliationdetails.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.chequereconciliationdetails.index');
    $breadcrumbs->push(trans('menus.backend.chequereconciliationdetails.create'), route('admin.chequereconciliationdetails.create'));
});

Breadcrumbs::register('admin.chequereconciliationdetails.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.chequereconciliationdetails.index');
    $breadcrumbs->push(trans('menus.backend.chequereconciliationdetails.edit'), route('admin.chequereconciliationdetails.edit', $id));
});

<?php

Breadcrumbs::register('admin.transactionanalysis.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.transactionanalysis.management'), route('admin.transactionanalysis.index'));
});

Breadcrumbs::register('admin.transactionanalysis.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.transactionanalysis.index');
    $breadcrumbs->push(trans('menus.backend.transactionanalysis.create'), route('admin.transactionanalysis.create'));
});

Breadcrumbs::register('admin.transactionanalysis.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.transactionanalysis.index');
    $breadcrumbs->push(trans('menus.backend.transactionanalysis.edit'), route('admin.transactionanalysis.edit', $id));
});

<?php

Breadcrumbs::register('admin.payers.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.payers.management'), route('admin.payers.index'));
});

Breadcrumbs::register('admin.payers.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.payers.index');
    $breadcrumbs->push(trans('menus.backend.payers.create'), route('admin.payers.create'));
});

Breadcrumbs::register('admin.payers.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.payers.index');
    $breadcrumbs->push(trans('menus.backend.payers.edit'), route('admin.payers.edit', $id));
});

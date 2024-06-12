<?php

Breadcrumbs::register('admin.locationtwos.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.locationtwos.management'), route('admin.locationtwos.index'));
});

Breadcrumbs::register('admin.locationtwos.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.locationtwos.index');
    $breadcrumbs->push(trans('menus.backend.locationtwos.create'), route('admin.locationtwos.create'));
});

Breadcrumbs::register('admin.locationtwos.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.locationtwos.index');
    $breadcrumbs->push(trans('menus.backend.locationtwos.edit'), route('admin.locationtwos.edit', $id));
});
